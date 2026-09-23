<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $packages = collect(config('travel.packages'));

        $theme = $request->query('theme', 'All');
        if (! in_array($theme, array_merge(['All'], config('travel.themes')), true)) {
            $theme = 'All';
        }

        $kind = $request->query('kind', 'Inbound');
        if (! in_array($kind, ['Inbound', 'Outbound'], true)) {
            $kind = 'Inbound';
        }

        $duration = $request->query('duration', 'All');
        if (! in_array($duration, ['All', '3–4', '5–6', '7+'], true)) {
            $duration = 'All';
        }

        $durationOf = fn (int $days) => $days <= 4 ? '3–4' : ($days <= 6 ? '5–6' : '7+');

        $shown = $packages
            ->where('kind', $kind)
            ->when($theme !== 'All', fn ($items) => $items->where('theme', $theme))
            ->when($duration !== 'All', fn ($items) => $items->filter(fn ($p) => $durationOf($p['days']) === $duration))
            ->values();

        return view('packages.index', [
            'shown' => $shown,
            'totalCount' => $packages->count(),
            'themes' => config('travel.themes'),
            'activeTheme' => $theme,
            'activeKind' => $kind,
            'activeDuration' => $duration,
        ]);
    }

    public function show(string $slug)
    {
        $package = collect(config('travel.packages'))->firstWhere('slug', $slug);

        if (! $package) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $keywords = travel_place($package['where']).','.$package['country'];
        $detailShots = collect(range(1, 4))
            ->map(fn ($i) => travel_img('niodet'.$package['id'].'-'.$i, 700, 500, $keywords));

        return view('packages.show', [
            'package' => $package,
            'itinerary' => config('travel.sample_itinerary'),
            'inclusions' => config('travel.inclusions'),
            'detailShots' => $detailShots,
        ]);
    }
}
