<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $packages = Package::query()->published()->ordered()->get();

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
        $package = Package::query()->published()->where('slug', $slug)->firstOrFail();

        return view('packages.show', [
            'package' => $package,
            'itinerary' => $package->itinerary,
            'inclusions' => $package->inclusions,
            'detailShots' => $package->galleryUrls(),
        ]);
    }
}
