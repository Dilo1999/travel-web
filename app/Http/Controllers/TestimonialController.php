<?php

namespace App\Http\Controllers;

class TestimonialController extends Controller
{
    public function index()
    {
        return view('testimonials', [
            'testimonials' => config('travel.testimonials'),
        ]);
    }
}
