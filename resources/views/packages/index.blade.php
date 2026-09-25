@extends('layouts.app')

@section('title', __('site.packages.meta_title').' — '.config('travel.brand.name'))
@section('description', __('site.packages.meta_description'))

@section('content')

@include('partials.page-hero', [
    'kicker' => __('site.packages.hero_kicker', ['count' => $totalCount]),
    'title' => __('site.packages.hero_title'),
    'subtitle' => __('site.packages.hero_subtitle'),
    'image' => 'niohero-packages',
    'keywords' => 'Sri Lanka,landscape',
])

<section class="px-4 pt-8 sm:px-5">
    <div class="mx-auto max-w-[1400px]">

        <div class="glass flex flex-wrap gap-7 rounded-[22px] p-4 max-sm:gap-5 sm:rounded-[26px] sm:p-6">
            <div class="max-sm:w-full">
                <div class="mb-2.5 text-[11.5px] font-semibold tracking-[0.1em] text-ink/45 uppercase">{{ __('site.packages.filter_theme') }}</div>
                <div class="filter-row flex flex-wrap gap-2 max-sm:-mx-4 max-sm:flex-nowrap max-sm:overflow-x-auto max-sm:px-4 max-sm:pb-1">
                    @foreach (array_merge(['All'], $themes) as $theme)
                        <a href="{{ route('packages.index', ['theme' => $theme, 'kind' => $activeKind, 'duration' => $activeDuration, 'destination' => $activeDestination?->slug]) }}"
                           class="chip {{ $activeTheme === $theme ? 'chip-active' : 'chip-inactive' }}">{{ $theme === 'All' ? __('site.destinations.tab_all') : travel_label(config('travel.theme_labels'), $theme) }}</a>
                    @endforeach
                </div>
            </div>
            <div class="max-sm:w-full">
                <div class="mb-2.5 text-[11.5px] font-semibold tracking-[0.1em] text-ink/45 uppercase">{{ __('site.packages.filter_destination') }}</div>
                <div class="filter-row flex flex-wrap gap-2 max-sm:-mx-4 max-sm:flex-nowrap max-sm:overflow-x-auto max-sm:px-4 max-sm:pb-1">
                    @foreach (['Inbound' => __('site.packages.destination_inbound_label'), 'Outbound' => __('site.packages.destination_outbound_label')] as $key => $label)
                        <a href="{{ route('packages.index', ['theme' => $activeTheme, 'kind' => $key, 'duration' => $activeDuration]) }}"
                           class="chip {{ ! $activeDestination && $activeKind === $key ? 'chip-active' : 'chip-inactive' }}">{{ $label }}</a>
                    @endforeach
                    @if ($activeDestination)
                        {{-- Reached from a destination's "See packages"; the × goes back to all packages of its type. --}}
                        <a href="{{ route('packages.index', ['theme' => $activeTheme, 'kind' => $activeKind, 'duration' => $activeDuration]) }}"
                           class="chip chip-active">{{ travel_t($activeDestination->name) }} <span aria-hidden="true">&times;</span></a>
                    @endif
                </div>
            </div>
            <div class="max-sm:w-full">
                <div class="mb-2.5 text-[11.5px] font-semibold tracking-[0.1em] text-ink/45 uppercase">{{ __('site.packages.filter_duration') }}</div>
                <div class="filter-row flex flex-wrap gap-2 max-sm:-mx-4 max-sm:flex-nowrap max-sm:overflow-x-auto max-sm:px-4 max-sm:pb-1">
                    @foreach (['All', '3–4', '5–6', '7+'] as $dur)
                        <a href="{{ route('packages.index', ['theme' => $activeTheme, 'kind' => $activeKind, 'duration' => $dur, 'destination' => $activeDestination?->slug]) }}"
                           class="chip {{ $activeDuration === $dur ? 'chip-active' : 'chip-inactive' }}">{{ travel_label(config('travel.duration_labels'), $dur) }}</a>
                    @endforeach
                </div>
            </div>
            <div class="ml-auto self-end text-[13px] text-ink/45">{{ $shown->count() }} / {{ $totalCount }}</div>
        </div>
    </div>
</section>

<section class="px-4 py-7 sm:px-5 sm:py-9">
    <div class="mx-auto max-w-[1400px]">
        @if ($shown->isEmpty())
            <p class="py-10 text-[15px] text-ink/45">
                {!! __('site.packages.empty_state', ['link' => '<a href="'.route('contact').'" class="text-accent-700 underline">'.__('site.packages.empty_state_link').'</a>']) !!}
            </p>
        @else
            <div class="grid grid-cols-1 gap-5.5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($shown as $package)
                    @include('partials.package-card', ['package' => $package])
                @endforeach
            </div>
        @endif
    </div>
</section>

@endsection
