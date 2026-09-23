<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'photos');
        if (! in_array($tab, ['photos', 'videos'], true)) {
            $tab = 'photos';
        }

        return view('gallery.index', [
            'tab' => $tab,
            'albums' => config('travel.albums'),
            'videos' => config('travel.videos'),
        ]);
    }

    public function album(string $slug)
    {
        $album = collect(config('travel.albums'))->firstWhere('slug', $slug);

        if (! $album) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return view('gallery.album', [
            'album' => $album,
            'shots' => $this->albumShots($album['seed'], $album['count'], $album['where']),
        ]);
    }

    private function albumShots(string $seed, int $count, string $keywords): array
    {
        $heights = [1100, 760, 900, 1200, 800, 980];
        $displayHeights = [300, 220, 260, 320, 240, 280];

        return collect(range(0, $count - 1))->map(function (int $i) use ($seed, $heights, $displayHeights, $keywords) {
            return [
                'img' => travel_img($seed.'-'.$i, 900, $heights[$i % 6], $keywords),
                'height' => $displayHeights[$i % 6],
            ];
        })->all();
    }
}
