@extends('layouts.app')

@section('title', 'Packages — '.config('travel.brand.name'))
@section('description', 'Browse our inbound Sri Lanka tours and outbound holidays, filterable by theme, destination and duration.')

@section('content')

<section class="px-4 pt-11 sm:px-5">
    <div class="mx-auto max-w-[1400px]">
        <span class="section-kicker">{{ $totalCount }} packages</span>
        <h1 class="mt-4 mb-6.5 text-[clamp(34px,4.6vw,64px)] leading-[1] tracking-[-.035em]">Packages</h1>

        <div class="glass flex flex-wrap gap-7 rounded-[26px] p-5.5 sm:p-6">
            <div>
                <div class="mb-2.5 text-[11.5px] font-semibold tracking-[0.1em] text-ink/45 uppercase">Theme</div>
                <div class="flex flex-wrap gap-2">
                    @foreach (array_merge(['All'], $themes) as $theme)
                        <a href="{{ route('packages.index', ['theme' => $theme, 'kind' => $activeKind, 'duration' => $activeDuration]) }}"
                           class="chip {{ $activeTheme === $theme ? 'chip-active' : 'chip-inactive' }}">{{ $theme }}</a>
                    @endforeach
                </div>
            </div>
            <div>
                <div class="mb-2.5 text-[11.5px] font-semibold tracking-[0.1em] text-ink/45 uppercase">Destination</div>
                <div class="flex flex-wrap gap-2">
                    @foreach (['Inbound' => 'Sri Lanka (inbound)', 'Outbound' => 'Outbound'] as $key => $label)
                        <a href="{{ route('packages.index', ['theme' => $activeTheme, 'kind' => $key, 'duration' => $activeDuration]) }}"
                           class="chip {{ $activeKind === $key ? 'chip-active' : 'chip-inactive' }}">{{ $label }}</a>
                    @endforeach
                </div>
            </div>
            <div>
                <div class="mb-2.5 text-[11.5px] font-semibold tracking-[0.1em] text-ink/45 uppercase">Duration</div>
                <div class="flex flex-wrap gap-2">
                    @foreach (['All', '3–4', '5–6', '7+'] as $dur)
                        <a href="{{ route('packages.index', ['theme' => $activeTheme, 'kind' => $activeKind, 'duration' => $dur]) }}"
                           class="chip {{ $activeDuration === $dur ? 'chip-active' : 'chip-inactive' }}">{{ $dur }}</a>
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
                Nothing matches that combination, <a href="{{ route('contact') }}" class="text-accent-700 underline">ask us to build it</a>.
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
