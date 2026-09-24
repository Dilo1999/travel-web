<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;

/**
 * A translation of one English string, made by the Translator page in the admin panel.
 * The site reads these through App\Translation\DatabaseLoader, cached per locale and group.
 */
class Translation extends Model
{
    /** Group used for content strings from config/travel.php; matches Laravel's JSON translation group. */
    public const CONTENT = '*';

    protected $fillable = ['locale', 'group', 'key', 'source', 'text'];

    protected static function booted(): void
    {
        static::saved(fn (self $translation) => static::flushCache($translation->locale, $translation->group));
        static::deleted(fn (self $translation) => static::flushCache($translation->locale, $translation->group));
    }

    /**
     * Translation lines for a locale and group, in the shape Laravel's loader expects:
     * dotted key => text for a lang group, English => text for content.
     */
    public static function lines(string $locale, string $group): array
    {
        try {
            return Cache::rememberForever(static::cacheKey($locale, $group), fn () => static::query()
                ->where('locale', $locale)
                ->where('group', $group)
                ->pluck('text', $group === self::CONTENT ? 'source' : 'key')
                ->all());
        } catch (QueryException) {
            // Table not migrated yet: behave as if there are no translations rather than breaking every page.
            return [];
        }
    }

    public static function flushCache(string $locale, string $group): void
    {
        Cache::forget(static::cacheKey($locale, $group));
    }

    private static function cacheKey(string $locale, string $group): string
    {
        return "translations.{$locale}.{$group}";
    }
}
