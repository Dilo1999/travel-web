<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function index()
    {
        return view('about', [
            'staff' => config('travel.staff'),
            'licences' => config('travel.licences'),
        ]);
    }
}
