<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * A tour package, edited in the admin panel (PackageResource).
 *
 * Text fields hold every language in one object, e.g. title = ['en' => ..., 'hi' => ..., 'ta' => ...],
 * which travel_t() resolves for the current locale. English is the source; translation_sources
 * remembers which English each translation was made from, so a translation whose English has
 * since changed shows as outdated in the admin panel and is picked up by the next Claude run.
 */
class Package extends Model
{
    public const SOURCE_LOCALE = 'en';

    /** Top-level text fields. */
    public const TEXT_FIELDS = ['title', 'location', 'pax', 'blurb', 'season'];

    /** Text fields inside each item of the list fields. */
    public const LIST_TEXT_FIELDS = [
        'itinerary' => ['title', 'body', 'stay', 'meals'],
        'inclusions' => ['item', 'note'],
    ];

    protected $fillable = [
        'slug', 'kind', 'theme', 'country', 'days',
        'title', 'location', 'pax', 'blurb', 'season',
        'itinerary', 'inclusions', 'hero_image', 'gallery', 'image_seed',
        'is_published', 'is_featured', 'sort_order',
    ];

    protected $casts = [
        'days' => 'integer',
        'title' => 'array',
        'location' => 'array',
        'pax' => 'array',
        'blurb' => 'array',
        'season' => 'array',
        'itinerary' => 'array',
        'inclusions' => 'array',
        'gallery' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'translation_sources' => 'array',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $package) {
            $package->normalizeText();
            $package->recordTranslationSources();
        });
    }

    /**
     * Store Hindi and Tamil as readable text rather than \u escapes.
     */
    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Every piece of text on the package, keyed by a stable path: 'title', 'itinerary.<item key>.body', ...
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
            $english = $value[self::SOURCE_LOCALE] ?? null;

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

        $english = $value[self::SOURCE_LOCALE] ?? '';
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
            if (! isset($value[self::SOURCE_LOCALE])) {
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
     * Where a path appears, in words, sent to Claude as context for the translation.
     */
    public function describePath(string $path): string
    {
        $segments = explode('.', $path);
        $title = $this->title[self::SOURCE_LOCALE] ?? $this->slug;

        if (count($segments) === 1) {
            return "tour package \"{$title}\": {$path}";
        }

        [$list, $key, $field] = $segments;
        $position = collect($this->{$list} ?? [])->search(fn ($item) => ($item['key'] ?? null) === $key);
        $label = $list === 'itinerary' ? 'day '.($position + 1) : 'included/excluded item';

        return "tour package \"{$title}\": {$label} {$field}";
    }

    public function heroImageUrl(int $width = 1920, int $height = 900): string
    {
        if ($this->hero_image) {
            return Storage::disk('public')->url($this->hero_image);
        }

        return travel_img($this->image_seed ?: 'niopkg'.$this->id, $width, $height, $this->photoKeywords());
    }

    /**
     * The photo strip on the package page: the uploaded gallery, or four placeholders until there is one.
     *
     * @return list<string>
     */
    public function galleryUrls(): array
    {
        if ($this->gallery) {
            return array_values(array_map(fn (string $path) => Storage::disk('public')->url($path), $this->gallery));
        }

        return array_map(
            fn (int $i) => travel_img('niodet'.$this->id.'-'.$i, 700, 500, $this->photoKeywords()),
            range(1, 4),
        );
    }

    public function photoKeywords(): string
    {
        return travel_place($this->location ?? '').','.$this->country;
    }

    /**
     * @param  array<string, mixed>  $attributes  package attributes with text fields as arrays
     * @return array<string, array<string, string>>
     */
    public static function entriesOf(array $attributes): array
    {
        $entries = [];

        foreach (self::TEXT_FIELDS as $field) {
            $entries[$field] = $attributes[$field] ?? [];
        }

        foreach (self::LIST_TEXT_FIELDS as $list => $fields) {
            foreach ($attributes[$list] ?? [] as $item) {
                foreach ($fields as $field) {
                    $entries["{$list}.{$item['key']}.{$field}"] = $item[$field] ?? [];
                }
            }
        }

        return array_map(fn ($value) => is_array($value) ? $value : [], $entries);
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

        foreach (self::TEXT_FIELDS as $field) {
            $this->{$field} = $clean($this->{$field});
        }

        foreach (self::LIST_TEXT_FIELDS as $list => $fields) {
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
                if ($locale === self::SOURCE_LOCALE) {
                    continue;
                }

                if (($before[$path][$locale] ?? null) !== $text || ! isset($sources[$locale][$path])) {
                    $sources[$locale][$path] = sha1($value[self::SOURCE_LOCALE] ?? '');
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

        foreach ([...self::TEXT_FIELDS, ...array_keys(self::LIST_TEXT_FIELDS)] as $field) {
            $original[$field] = $this->getOriginal($field);
        }

        return $original;
    }
}
