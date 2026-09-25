<?php

namespace App\Services;

use App\Models\Translation;
use Carbon\CarbonInterface;
use Illuminate\Support\Arr;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * English is the only language written by hand: UI strings in resources/lang/en/*.php and
 * content in config/travel.php (packages live in the database; see PackageTranslations). A translation run (the Translator page in the admin panel)
 * sends all of it to Claude for every other locale and saves the results in the translations
 * table, which is what the site reads. The API is only used during a run.
 */
class SiteTranslations
{
    public const SOURCE = 'en';

    /**
     * @return array<string, string> locale code => display name, e.g. 'ta' => 'Tamil (தமிழ்)'
     */
    public function targetLocales(): array
    {
        $names = [];

        foreach (LaravelLocalization::getSupportedLocales() as $code => $properties) {
            if ($code !== self::SOURCE) {
                $names[$code] = "{$properties['name']} ({$properties['native']})";
            }
        }

        return $names;
    }

    /**
     * Every string to translate, UI strings first so their terms can guide the content.
     *
     * @return array<string, array{locale: string, group: string, key: string, source: string, context: string}>
     *               keyed by "locale|group|key"
     */
    public function strings(): array
    {
        $strings = [];
        $ui = $this->uiSource();

        foreach (array_keys($this->targetLocales()) as $locale) {
            foreach ($ui as $group => $lines) {
                foreach ($lines as $key => $english) {
                    $strings["{$locale}|{$group}|{$key}"] = ['locale' => $locale, 'group' => $group, 'key' => $key, 'source' => $english, 'context' => "{$group}.{$key}"];
                }
            }

            foreach ($this->contentSource($locale) as $english => $context) {
                $key = sha1($english);
                $strings["{$locale}|".Translation::CONTENT."|{$key}"] = ['locale' => $locale, 'group' => Translation::CONTENT, 'key' => $key, 'source' => $english, 'context' => $context];
            }
        }

        return $strings;
    }

    /**
     * How much of the current English each locale has an up-to-date translation for.
     *
     * @return array<string, array{name: string, total: int, translated: int, updated: ?CarbonInterface}>
     */
    public function status(): array
    {
        $rows = Translation::query()
            ->get(['locale', 'group', 'key', 'source', 'updated_at'])
            ->keyBy(fn (Translation $row) => "{$row->locale}|{$row->group}|{$row->key}");

        $status = [];
        foreach ($this->targetLocales() as $locale => $name) {
            $status[$locale] = ['name' => $name, 'total' => 0, 'translated' => 0, 'updated' => null];
        }

        foreach ($this->strings() as $slot => $string) {
            $locale = $string['locale'];
            $status[$locale]['total']++;
            $row = $rows[$slot] ?? null;

            if ($row && $row->source === $string['source']) {
                $status[$locale]['translated']++;
                $status[$locale]['updated'] = max($status[$locale]['updated'], $row->updated_at);
            }
        }

        return $status;
    }

    /**
     * Strings not yet translated in the run that started at $since, minus the ones given up on.
     *
     * @param  list<string>  $skipped  "locale|group|key" slots that failed in this run
     */
    public function remaining(CarbonInterface $since, array $skipped = []): array
    {
        $done = Translation::query()
            ->where('updated_at', '>=', $since)
            ->get(['locale', 'group', 'key', 'source'])
            ->mapWithKeys(fn (Translation $row) => ["{$row->locale}|{$row->group}|{$row->key}" => $row->source]);

        return array_filter(
            array_diff_key($this->strings(), array_flip($skipped)),
            fn (array $string, string $slot) => ($done[$slot] ?? null) !== $string['source'],
            ARRAY_FILTER_USE_BOTH,
        );
    }

    /**
     * Translate and save the next batch (one API request, plus a retry for anything rejected).
     *
     * @param  list<string>  $skipped  failed slots; this adds any new failures so they aren't retried forever
     * @return int|null strings saved, or null when the run has nothing left to do
     */
    public function translateNext(CarbonInterface $since, array &$skipped): ?int
    {
        $remaining = $this->remaining($since, $skipped);

        if (! $remaining) {
            return null;
        }

        $locale = reset($remaining)['locale'];
        $translator = $this->translator();

        $items = [];
        foreach ($remaining as $slot => $string) {
            if ($string['locale'] === $locale) {
                $items[$slot] = ['text' => $string['source'], 'context' => $string['context']];
            }
        }
        $batch = $translator->batches($items)[0];

        $saved = 0;
        $failed = $translator->translate(
            $batch,
            $this->targetLocales()[$locale],
            $this->glossary($locale),
            function (array $done) use ($remaining, &$saved) {
                $this->save(array_intersect_key($remaining, $done), $done);
                $saved += count($done);
            },
        );

        array_push($skipped, ...array_keys($failed));

        return $saved;
    }

    public function translator(): ClaudeTranslator
    {
        return app(ClaudeTranslator::class, [
            'model' => config('services.anthropic.model'),
            'apiKey' => config('services.anthropic.key'),
            'brand' => config('travel.brand.name'),
        ]);
    }

    /**
     * Delete translations whose English no longer exists on the site.
     */
    public function removeStale(): int
    {
        $strings = $this->strings();
        $stale = Translation::query()
            ->get(['id', 'locale', 'group', 'key'])
            ->reject(fn (Translation $row) => isset($strings["{$row->locale}|{$row->group}|{$row->key}"]));

        // One by one so the model events clear the cache.
        $stale->each->delete();

        return $stale->count();
    }

    /**
     * The locale's current short UI translations, sent along so terminology stays consistent.
     *
     * @return array<string, string> English => translation
     */
    public function glossary(string $locale): array
    {
        return Translation::query()
            ->where('locale', $locale)
            ->where('group', '!=', Translation::CONTENT)
            ->get(['source', 'text'])
            ->filter(fn (Translation $row) => mb_strlen($row->source) <= 60)
            ->pluck('text', 'source')
            ->all();
    }

    /**
     * @param  array<string, array{locale: string, group: string, key: string, source: string}>  $strings  by slot
     * @param  array<string, string>  $texts  translation by slot
     */
    private function save(array $strings, array $texts): void
    {
        $now = now();
        $records = [];

        foreach ($strings as $slot => $string) {
            $records[] = Arr::only($string, ['locale', 'group', 'key', 'source']) + ['text' => $texts[$slot], 'created_at' => $now, 'updated_at' => $now];
        }

        Translation::upsert($records, ['locale', 'group', 'key'], ['source', 'text', 'updated_at']);

        foreach (array_unique(array_map(fn (array $record) => "{$record['locale']}|{$record['group']}", $records)) as $slot) {
            Translation::flushCache(...explode('|', $slot));
        }
    }

    /**
     * @return array<string, array<string, string>> lang group => [dotted key => English]
     */
    private function uiSource(): array
    {
        $source = [];

        foreach (glob(lang_path(self::SOURCE.'/*.php')) as $file) {
            $source[basename($file, '.php')] = array_filter(Arr::dot(require $file), 'is_string');
        }

        return $source;
    }

    /**
     * Every English content string in config/travel.php that the locale has no inline value for,
     * mapped to the config path of its first use (sent to Claude as context).
     *
     * @return array<string, string>
     */
    private function contentSource(string $locale): array
    {
        $locales = array_keys(LaravelLocalization::getSupportedLocales());
        $strings = [];

        $walk = function (mixed $node, string $path) use (&$walk, &$strings, $locales, $locale) {
            if (! is_array($node)) {
                return;
            }

            // A locale-keyed field: ['en' => '...'] with no keys other than locale codes.
            if (is_string($node[self::SOURCE] ?? null) && ! array_diff(array_keys($node), $locales)) {
                if (! isset($node[$locale])) {
                    $strings[$node[self::SOURCE]] ??= $path;
                }

                return;
            }

            foreach ($node as $key => $child) {
                $walk($child, "{$path}.{$key}");
            }
        };

        $walk(config('travel'), 'travel');

        return $strings;
    }
}
