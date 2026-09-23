@extends('layouts.app')

@section('title', 'Destinations — '.config('travel.brand.name'))
@section('description', 'Every corner of Sri Lanka we run inbound tours in, plus the outbound holidays we book beyond it.')

@section('content')

<section class="px-4 pt-11 sm:px-5">
    <div class="mx-auto max-w-[1400px]">
        <span class="section-kicker">Inbound &amp; outbound</span>
        <h1 class="mt-4 mb-4.5 max-w-[22ch] text-[clamp(34px,5vw,70px)] leading-[1] tracking-[-.035em]">Every corner of Sri Lanka, and the holidays beyond it</h1>
        <p class="mb-6.5 max-w-[62ch] text-[17px] leading-relaxed text-ink/60">
            Sri Lanka is our home ground, we run every inbound tour ourselves. For travel beyond the island we work with vetted ground partners and still handle the whole booking from Colombo.
        </p>
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
