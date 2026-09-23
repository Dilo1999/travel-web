<?php

if (! function_exists('travel_img')) {
    /**
     * Placeholder photography URL until real photos are supplied.
     * Deterministic by seed, so the same card always shows the same image.
     */
    function travel_img(string $seed, int $width = 1000, int $height = 700): string
    {
        return "https://picsum.photos/seed/{$seed}/{$width}/{$height}";
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
     * Resolve a locale-keyed content field (['en' => ..., 'hi' => ..., 'ta' => ...])
     * to the current app locale, falling back to the fallback locale then English.
     */
    function travel_t(mixed $field): mixed
    {
        if (! is_array($field)) {
            return $field;
        }

        return $field[app()->getLocale()]
            ?? $field[config('app.fallback_locale')]
            ?? reset($field);
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
