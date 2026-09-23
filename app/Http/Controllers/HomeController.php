<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $packages = collect(config('travel.packages'));
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

        $featured = collect(config('travel.featured_packages'))
            ->map(fn ($id) => $packages->firstWhere('id', $id))
            ->filter();

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
