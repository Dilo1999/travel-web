@extends('layouts.app')

@section('title', __('site.destinations.meta_title').' — '.config('travel.brand.name'))
@section('description', __('site.destinations.meta_description'))

@section('content')

@include('partials.page-hero', [
    'kicker' => __('site.destinations.hero_kicker'),
    'title' => __('site.destinations.hero_title'),
    'subtitle' => __('site.destinations.hero_subtitle'),
    'image' => 'niohero-destinations',
    'keywords' => 'Sri Lanka,coast',
])

<section class="px-4 pt-8 sm:px-5">
    <div class="mx-auto max-w-[1400px]">
        <div class="flex flex-wrap gap-2">
            @foreach (['All' => __('site.destinations.tab_all'), 'Inbound' => __('site.destinations.tab_inbound'), 'Outbound' => __('site.destinations.tab_outbound')] as $key => $label)
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
