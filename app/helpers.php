<?php

if (! function_exists('travel_img')) {
    /**
     * Placeholder photography URL until real photos are supplied.
     *
     * When $keywords is given, sources a keyword-matched photo (LoremFlickr)
     * so the placeholder actually resembles the place/subject shown, instead
     * of a completely unrelated random image. The `lock` param pins it to one
     * photo per seed+keyword combination, so the same card always shows the
     * same image rather than a different random match on every load.
     * Falls back to a random-by-seed photo when no keyword is available.
     */
    function travel_img(string $seed, int $width = 1000, int $height = 700, ?string $keywords = null): string
    {
        if ($keywords) {
            $haystack = strtolower($keywords);
            $photos = config('travel.stock_photos', []);
            uksort($photos, fn ($a, $b) => strlen($b) <=> strlen($a));

            foreach ($photos as $key => $url) {
                if (str_contains($haystack, $key)) {
                    return $url;
                }
            }
        }

        return "https://picsum.photos/seed/{$seed}/{$width}/{$height}";
    }
}

if (! function_exists('travel_place')) {
    /**
     * Reduce a compound location string (e.g. "Kandy & the hill country",
     * "Galle · Mirissa · Ella") down to a single, clean place name suitable
     * as an image-search keyword. Always resolves from the English value,
     * since place names are proper nouns and search better untranslated.
     */
    function travel_place(array|string $field): string
    {
        $value = is_array($field) ? ($field['en'] ?? reset($field)) : $field;
        $value = explode('·', $value)[0];
        $value = preg_split('/\s*&\s*|\s+and\s+/i', $value)[0];
        $value = preg_replace('/^the\s+/i', '', trim($value));

        return trim($value);
    }
}

if (! function_exists('whatsapp_link')) {
    function whatsapp_link(string $number, ?string $message = null): string
    {
        $digits = preg_replace('/\D/', '', $number);
        $message ??= travel_t(config('travel.brand.whatsapp_message'));

        return 'https://wa.me/'.$digits.'?text='.rawurlencode($message);
    }
}

if (! function_exists('travel_t')) {
    /**
     * Resolve a locale-keyed content field (['en' => ...]) to the current app locale.
     * An inline value for the locale wins; otherwise the English text is looked up in
     * the translations table (filled by the Translator page in the admin panel),
     * falling back to the fallback locale then the first value.
     */
    function travel_t(mixed $field): mixed
    {
        if (! is_array($field)) {
            return $field;
        }

        $locale = app()->getLocale();

        if (isset($field[$locale])) {
            return $field[$locale];
        }

        if (is_string($field['en'] ?? null) && ($translated = travel_translation($field['en'], $locale)) !== null) {
            return $translated;
        }

        return $field[config('app.fallback_locale')] ?? reset($field);
    }
}

if (! function_exists('travel_translation')) {
    /**
     * Look up the generated translation of an English content string
     * in the translations table, or null if there is none.
     */
    function travel_translation(string $english, string $locale): ?string
    {
        static $loaded = [];

        $loaded[$locale] ??= app('translator')->getLoader()->load($locale, '*', '*');

        return $loaded[$locale][$english] ?? null;
    }
}

if (! function_exists('travel_label')) {
    /**
     * Look up the translated display label for a stable content key
     * (e.g. a theme or "kind" value used in filtering/URLs) from a
     * locale-keyed label map, falling back to the key itself.
     */
    function travel_label(array $map, string $key): string
    {
        return isset($map[$key]) ? travel_t($map[$key]) : $key;
    }
}
