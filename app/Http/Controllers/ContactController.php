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
            'prefillMessage' => $request->query('package') ? __('site.contact.enquiring_about', ['package' => $request->query('package')]) : null,
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
                    $fail(__('site.contact.validation.phone_country_code'));
                }
            }],
            'pax' => ['required', 'integer', 'min:1'],
            'month' => ['nullable', 'string', 'max:20'],
            'year' => ['nullable', 'string', 'max:4'],
            'interest' => ['required', 'string', 'max:100'],
            'message' => ['nullable', 'string', 'max:2000'],
        ], [
            'name.required' => __('site.contact.validation.name_required'),
            'pax.required' => __('site.contact.validation.pax_required'),
            'pax.integer' => __('site.contact.validation.pax_integer'),
            'pax.min' => __('site.contact.validation.pax_min'),
            'interest.required' => __('site.contact.validation.interest_required'),
            'email.email' => __('site.contact.validation.email_email'),
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
