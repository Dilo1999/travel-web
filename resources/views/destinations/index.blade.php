@extends('layouts.app')

@section('title', 'Destinations — '.config('travel.brand.name'))
@section('description', 'Every corner of Sri Lanka we run inbound tours in, plus the outbound holidays we book beyond it.')

@section('content')

@include('partials.page-hero', [
    'kicker' => 'Inbound & outbound',
    'title' => 'Every corner of Sri Lanka, and the holidays beyond it',
    'subtitle' => 'Sri Lanka is our home ground, we run every inbound tour ourselves. For travel beyond the island we work with vetted ground partners and still handle the whole booking from Colombo.',
    'image' => 'niohero-destinations',
])

<section class="px-4 pt-8 sm:px-5">
    <div class="mx-auto max-w-[1400px]">
        <div class="flex flex-wrap gap-2">
            @foreach (['All' => 'All destinations', 'Inbound' => 'Sri Lanka (inbound)', 'Outbound' => 'Outbound'] as $key => $label)
                <a href="{{ route('destinations', $key === 'All' ? [] : ['kind' => $key]) }}"
                   class="chip {{ $activeTab === $key ? 'chip-active' : 'chip-inactive' }}">{{ $label }}</a>
            @endforeach
        </div>
    </div>
</section>

<section class="px-4 py-8 sm:px-5 sm:py-9">
    <div class="mx-auto grid max-w-[1400px] grid-cols-1 gap-5.5 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($destinations as $destination)
            @include('partials.destination-card', ['destination' => $destination])
        @endforeach
    </div>
</section>

@endsection
