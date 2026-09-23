<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $packages = collect(config('travel.packages'));
        $themeImages = config('travel.theme_images');

        $themeCards = collect(config('travel.themes'))->map(function (string $theme) use ($packages, $themeImages) {
            $hasInbound = $packages->where('theme', $theme)->where('kind', 'Inbound')->isNotEmpty();

            return [
                'label' => $theme,
                'img' => travel_img($themeImages[$theme] ?? $theme, 900, 700),
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
