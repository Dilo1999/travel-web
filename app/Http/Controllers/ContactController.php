<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        return view('contact', [
            'interests' => config('travel.interests'),
            'countries' => config('travel.countries'),
            'dialCodes' => config('travel.dial_codes'),
            'contacts' => config('travel.contacts'),
            'prefillInterest' => $request->query('interest'),
            'prefillMessage' => $request->query('package') ? 'Enquiring about: '.$request->query('package') : null,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:255'],
            'dial' => ['nullable', 'string', 'max:8'],
            'phone' => ['nullable', 'string', 'max:30', function ($attribute, $value, $fail) {
                $digits = preg_replace('/\D/', '', (string) $value);
                if ($digits !== '' && strlen($digits) < 9) {
                    $fail('Include the country code, e.g. +91.');
                }
            }],
            'pax' => ['required', 'integer', 'min:1'],
            'month' => ['nullable', 'string', 'max:20'],
            'year' => ['nullable', 'string', 'max:4'],
            'interest' => ['required', 'string', 'max:100'],
            'message' => ['nullable', 'string', 'max:2000'],
        ], [
            'name.required' => 'Tell us who to address the quote to.',
            'pax.required' => 'How many are travelling?',
            'pax.integer' => 'Enter a number of travellers.',
            'pax.min' => 'Enter a number of travellers.',
            'interest.required' => 'Pick what you are looking for.',
            'email.email' => 'That email does not look right.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        $reference = 'NIO-'.random_int(1000, 9999);

        Log::info('Travel enquiry received', ['reference' => $reference] + $data);

        return redirect()
            ->route('contact')
            ->with('sent', true)
            ->with('reference', $reference)
            ->with('sentTo', $data['email'] ?? ($data['phone'] ?? 'you'));
    }
}
