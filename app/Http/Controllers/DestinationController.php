<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('kind', 'All');
        if (! in_array($tab, ['All', 'Inbound', 'Outbound'], true)) {
            $tab = 'All';
        }

        $destinations = Destination::query()
            ->published()
            ->ordered()
            ->withPublishedPackageCount()
            ->when($tab !== 'All', fn ($query) => $query->where('kind', $tab))
            ->get();

        return view('destinations.index', [
            'destinations' => $destinations,
            'activeTab' => $tab,
        ]);
    }
}
