@extends('layouts.app')

@section('title', 'Gallery — '.config('travel.brand.name'))
@section('description', 'One album per tour, plus the clips our guests and guides post from the road.')

@section('content')

<section class="px-4 pt-11 sm:px-5">
    <div class="mx-auto max-w-[1400px]">
        <span class="section-kicker">Albums &amp; clips</span>
        <h1 class="mt-4 mb-3.5 text-[clamp(34px,4.6vw,64px)] leading-[1] tracking-[-.035em]">Gallery</h1>
        <p class="mb-6 max-w-[60ch] text-base text-ink/60">One album per tour, plus the clips our guests and guides post from the road.</p>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('gallery', ['tab' => 'photos']) }}" class="chip {{ $tab === 'photos' ? 'chip-active' : 'chip-inactive' }}">Tour albums</a>
            <a href="{{ route('gallery', ['tab' => 'videos']) }}" class="chip {{ $tab === 'videos' ? 'chip-active' : 'chip-inactive' }}">Video gallery</a>
        </div>
    </div>
</section>

@if ($tab === 'photos')
<section class="px-4 py-7 sm:px-5 sm:py-9">
    <div class="mx-auto grid max-w-[1400px] grid-cols-1 gap-5.5 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($albums as $album)
            <a href="{{ route('gallery.album', $album['slug']) }}" class="glass-strong block overflow-hidden rounded-[28px] transition-transform duration-300 hover:-translate-y-2">
                <span class="relative block h-[230px] bg-[#dfe5de] bg-cover bg-center" style="background-image:url('{{ travel_img($album['seed'].'-0', 1000, 700) }}')">
                    <span class="absolute inset-0" style="background:linear-gradient(180deg,rgba(8,22,12,0),rgba(8,22,12,.55))"></span>
                    <span class="absolute top-3.5 right-3.5 rounded-full bg-white/85 px-3 py-1.5 text-[11.5px] font-bold text-accent-800 backdrop-blur-md">{{ $album['count'] }} photos</span>
                    <span class="absolute bottom-3.5 left-3.5 flex gap-1.5">
                        @foreach ([1, 2, 3] as $i)
                            <span class="block h-11 w-11 rounded-xl border-2 border-white/80 bg-[#dfe5de] bg-cover bg-center" style="background-image:url('{{ travel_img($album['seed'].'-'.$i, 300, 300) }}')"></span>
                        @endforeach
                    </span>
                </span>
                <span class="block px-6 pt-5.5 pb-6">
                    <span class="block text-[11.5px] font-semibold tracking-[0.1em] text-accent-700 uppercase">{{ $album['theme'] }}</span>
                    <span class="mt-2 mb-1.5 block text-xl font-semibold tracking-[-.02em]" style="font-family:var(--font-heading)">{{ $album['title'] }}</span>
                    <span class="block text-[13px] text-ink/60">{{ $album['where'] }} · {{ $album['when'] }}</span>
                </span>
            </a>
        @endforeach
    </div>
</section>
@else
<section class="px-4 py-7 sm:px-5 sm:py-9">
    <div class="mx-auto max-w-[1400px]">
        <div class="grid grid-cols-1 gap-5.5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($videos as $video)
                @php
                    $badgeColor = match ($video['source']) {
                        'YouTube' => '#ff0000',
                        'Facebook' => '#1877f2',
                        default => '#111111',
                    };
                @endphp
                <a href="{{ $video['url'] }}" target="_blank" rel="noopener" class="glass-strong block overflow-hidden rounded-[28px] transition-transform duration-300 hover:-translate-y-2">
                    <span class="relative block h-[220px] bg-[#dfe5de] bg-cover bg-center" style="background-image:url('{{ travel_img($video['seed'], 1000, 700) }}')">
                        <span class="absolute inset-0" style="background:linear-gradient(180deg,rgba(8,22,12,.1),rgba(8,22,12,.6))"></span>
                        <span class="absolute inset-0 grid place-items-center">
                            <span class="grid h-[62px] w-[62px] place-items-center rounded-full bg-white/90 shadow-[0_12px_30px_-10px_rgba(8,26,14,.7)]">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="var(--color-accent-800)"><path d="M8 5v14l11-7z"/></svg>
                            </span>
                        </span>
                        <span class="absolute top-3.5 left-3.5 rounded-full px-3 py-1.5 text-[11px] font-bold tracking-[0.06em] text-white uppercase" style="background:{{ $badgeColor }}">{{ $video['source'] }}</span>
                    </span>
                    <span class="block px-5.5 pt-5 pb-5.5">
                        <span class="mb-1.5 block text-lg font-semibold tracking-[-.015em]" style="font-family:var(--font-heading)">{{ $video['title'] }}</span>
                        <span class="block text-[12.5px] text-ink/45">{{ $video['meta'] }}</span>
                    </span>
                </a>
            @endforeach
        </div>
        <p class="mt-6.5 text-[13px] text-ink/45">Videos stay on Facebook, TikTok or YouTube — tap a card to open it there.</p>
    </div>
</section>
@endif

@endsection
