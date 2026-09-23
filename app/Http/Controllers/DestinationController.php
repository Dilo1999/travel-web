<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('kind', 'All');
        if (! in_array($tab, ['All', 'Inbound', 'Outbound'], true)) {
            $tab = 'All';
        }

        $destinations = collect(config('travel.destinations'))
            ->when($tab !== 'All', fn ($items) => $items->where('kind', $tab))
            ->values();

        return view('destinations.index', [
            'destinations' => $destinations,
            'activeTab' => $tab,
        ]);
    }
}
