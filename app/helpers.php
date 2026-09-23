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
        $message ??= config('travel.brand.whatsapp_message');

        return 'https://wa.me/'.$digits.'?text='.rawurlencode($message);
    }
}
