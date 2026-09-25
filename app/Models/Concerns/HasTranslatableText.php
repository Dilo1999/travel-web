<?php

namespace App\Models\Concerns;

use App\Models\Contracts\TranslatableContent;
use Illuminate\Support\Str;

/**
 * Text fields that hold every language in one object, e.g. name = ['en' => ..., 'hi' => ..., 'ta' => ...],
 * which travel_t() resolves for the current locale. English is the source; translation_sources
 * (a JSON column) remembers which English each translation was made from, so a translation whose
 * English has since changed shows as outdated in the admin panel and is redone by the next Claude run.
 *
 * The model declares TEXT_FIELDS (top-level text) and LIST_TEXT_FIELDS (text inside each item of a
 * list field, keyed by list name), casts them and translation_sources to array, and implements
 * describePath().
 */
trait HasTranslatableText
{
    public static function bootHasTranslatableText(): void
    {
        static::saving(function (self $model) {
            $model->normalizeText();
            $model->recordTranslationSources();
        });
    }

    /**
     * Every piece of text, keyed by a stable path: 'name', 'itinerary.<item key>.body', ...
     *
     * @return array<string, array<string, string>> path => [locale => text]
     */
    public function textEntries(): array
    {
        return static::entriesOf($this->attributesToArray());
    }

    /**
     * Translations that need (re)doing for a locale: empty, or made from English that has since changed.
     *
     * @return array<string, string> path => English
     */
    public function pendingTranslations(string $locale, bool $includeUpToDate = false): array
    {
        $pending = [];

        foreach ($this->textEntries() as $path => $value) {
            $english = $value[TranslatableContent::SOURCE_LOCALE] ?? null;

            if ($english !== null && ($includeUpToDate || $this->translationState($path, $locale) !== 'current')) {
                $pending[$path] = $english;
            }
        }

        return $pending;
    }

    /**
     * 'missing' (no translation), 'outdated' (the English changed after it was translated) or 'current'.
     */
    public function translationState(string $path, string $locale): string
    {
        $value = $this->textEntries()[$path] ?? [];

        if (! isset($value[$locale])) {
            return 'missing';
        }

        $english = $value[TranslatableContent::SOURCE_LOCALE] ?? '';
        $source = $this->translation_sources[$locale][$path] ?? null;

        return $source === sha1($english) ? 'current' : 'outdated';
    }

    /**
     * @return array{total: int, missing: int, outdated: int}
     */
    public function translationSummary(string $locale): array
    {
        $summary = ['total' => 0, 'missing' => 0, 'outdated' => 0];

        foreach ($this->textEntries() as $path => $value) {
            if (! isset($value[TranslatableContent::SOURCE_LOCALE])) {
                continue;
            }

            $summary['total']++;
            $state = $this->translationState($path, $locale);

            if ($state !== 'current') {
                $summary[$state]++;
            }
        }

        return $summary;
    }

    /**
     * Write one translation into the text at a path from textEntries().
     */
    public function setTranslation(string $path, string $locale, string $text): void
    {
        $segments = explode('.', $path);

        if (count($segments) === 1) {
            $this->{$path} = [...($this->{$path} ?? []), $locale => $text];

            return;
        }

        [$list, $key, $field] = $segments;
        $items = $this->{$list} ?? [];

        foreach ($items as $index => $item) {
            if (($item['key'] ?? null) === $key) {
                $items[$index][$field] = [...($item[$field] ?? []), $locale => $text];
            }
        }

        $this->{$list} = $items;
    }

    /**
     * The list field an item-level text field belongs to ('itinerary.'), or '' for a top-level field.
     */
    public static function listPrefixFor(string $field): string
    {
        foreach (static::LIST_TEXT_FIELDS as $list => $fields) {
            if (in_array($field, $fields, true)) {
                return "{$list}.";
            }
        }

        return '';
    }

    /**
     * @param  array<string, mixed>  $attributes  attributes with text fields as arrays
     * @return array<string, array<string, string>>
     */
    public static function entriesOf(array $attributes): array
    {
        $entries = [];

        foreach (static::TEXT_FIELDS as $field) {
            $entries[$field] = $attributes[$field] ?? [];
        }

        foreach (static::LIST_TEXT_FIELDS as $list => $fields) {
            foreach ($attributes[$list] ?? [] as $item) {
                foreach ($fields as $field) {
                    $entries["{$list}.{$item['key']}.{$field}"] = $item[$field] ?? [];
                }
            }
        }

        return array_map(fn ($value) => is_array($value) ? $value : [], $entries);
    }

    /**
     * Store Hindi and Tamil as readable text rather than \u escapes.
     */
    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Trim text, drop empty languages (so the site falls back to English) and give list items a stable key.
     */
    private function normalizeText(): void
    {
        $clean = fn ($value) => array_filter(
            array_map(fn ($text) => is_string($text) ? trim($text) : null, is_array($value) ? $value : []),
            fn ($text) => $text !== null && $text !== '',
        );

        foreach (static::TEXT_FIELDS as $field) {
            $this->{$field} = $clean($this->{$field});
        }

        foreach (static::LIST_TEXT_FIELDS as $list => $fields) {
            $this->{$list} = array_values(array_map(function ($item) use ($fields, $clean) {
                $item['key'] = ($item['key'] ?? null) ?: (string) Str::uuid();
                foreach ($fields as $field) {
                    $item[$field] = $clean($item[$field] ?? []);
                }

                return $item;
            }, $this->{$list} ?? []));
        }
    }

    /**
     * Any translation that changed in this save was written against the English as it is now.
     */
    private function recordTranslationSources(): void
    {
        $before = $this->exists ? static::entriesOf($this->originalTextAttributes()) : [];
        $sources = $this->translation_sources ?? [];

        foreach ($this->textEntries() as $path => $value) {
            foreach ($value as $locale => $text) {
                if ($locale === TranslatableContent::SOURCE_LOCALE) {
                    continue;
                }

                if (($before[$path][$locale] ?? null) !== $text || ! isset($sources[$locale][$path])) {
                    $sources[$locale][$path] = sha1($value[TranslatableContent::SOURCE_LOCALE] ?? '');
                }
            }
        }

        // Forget sources for translations and items that no longer exist.
        $entries = $this->textEntries();
        foreach ($sources as $locale => $paths) {
            $sources[$locale] = array_filter($paths, fn ($hash, $path) => isset($entries[$path][$locale]), ARRAY_FILTER_USE_BOTH);
        }

        $this->translation_sources = array_filter($sources);
    }

    private function originalTextAttributes(): array
    {
        $original = [];

        foreach ([...static::TEXT_FIELDS, ...array_keys(static::LIST_TEXT_FIELDS)] as $field) {
            $original[$field] = $this->getOriginal($field);
        }

        return $original;
    }
}
