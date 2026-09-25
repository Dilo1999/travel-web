<?php

namespace App\Http\Controllers;

use App\Models\Package;

class HomeController extends Controller
{
    public function index()
    {
        $packages = Package::query()->published()->ordered()->get();
        $themeImages = config('travel.theme_images');

        $themeKeywords = config('travel.theme_photo_keywords');

        $themeCards = collect(config('travel.themes'))->map(function (string $theme) use ($packages, $themeImages, $themeKeywords) {
            $hasInbound = $packages->where('theme', $theme)->where('kind', 'Inbound')->isNotEmpty();

            return [
                'key' => $theme,
                'label' => travel_label(config('travel.theme_labels'), $theme),
                'img' => travel_img($themeImages[$theme] ?? $theme, 900, 700, $themeKeywords[$theme] ?? $theme),
                'count' => $packages->where('theme', $theme)->count(),
                'kind' => $hasInbound ? 'Inbound' : 'Outbound',
            ];
        });

        $featured = $packages->where('is_featured', true)->take(3);

        return view('home', [
            'themeCards' => $themeCards,
            'featured' => $featured,
            'destinations' => collect(config('travel.destinations'))->take(5),
            'pillars' => config('travel.pillars'),
            'testimonials' => config('travel.testimonials'),
            'albums' => collect(config('travel.albums'))->take(4),
        ]);
    }
}
