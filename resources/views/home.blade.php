@extends('layouts.app')

@section('title', config('travel.brand.tagline').' — '.config('travel.brand.name'))

@section('content')

{{-- Hero --}}
<section class="relative -mt-20 flex h-screen min-h-[560px] items-end overflow-hidden">
    <div class="animate-hero-video absolute inset-0 bg-[#0c1a10] bg-cover bg-center" style="background-image:url('{{ travel_img('niohero3', 1920, 1080) }}')"></div>
    <div class="absolute inset-0" style="background:linear-gradient(180deg,rgba(8,22,12,.50) 0%,rgba(8,22,12,.10) 34%,rgba(8,22,12,.80) 100%)"></div>

    <div class="relative mx-auto w-full max-w-[1440px] px-6 pt-16 pb-14 sm:px-10 sm:pb-20">
        <div class="animate-hero mb-6 inline-flex items-center gap-2.5 rounded-full border border-white/30 bg-white/16 px-4 py-2 backdrop-blur-md">
            <span class="h-[7px] w-[7px] rounded-full bg-[#7ee08f] shadow-[0_0_12px_#7ee08f]"></span>
            <span class="text-xs font-semibold tracking-[0.06em] text-white uppercase">Inbound &amp; outbound tours</span>
        </div>
        <h1 class="animate-hero mb-5 max-w-[19ch] text-[clamp(38px,5.6vw,84px)] leading-[1] tracking-[-.035em] text-white text-balance">
            {{ config('travel.brand.tagline') }}
        </h1>
        <p class="animate-hero mb-7 max-w-[58ch] text-[clamp(15px,1.3vw,19px)] leading-relaxed text-white/88">
            Adventures, safaris, heritage, honeymoons, reefs and group pilgrimages, planned and run by the people who answer your messages. Plus outbound holidays across the world.
        </p>
        <div class="animate-hero flex flex-wrap gap-3">
            <a href="{{ route('packages.index') }}" class="btn btn-primary px-6.5 py-4 text-sm">Browse packages</a>
            <a href="{{ route('destinations') }}" class="btn btn-dark px-6.5 py-4 text-sm">See destinations</a>
        </div>
    </div>
</section>

{{-- Ways to travel --}}
<section class="px-4 pt-16 sm:px-5" data-rail>
    <div class="mx-auto max-w-[1400px]">
        <div class="mb-6 flex flex-wrap items-end justify-between gap-6">
            <div>
                <span class="section-kicker">Ways to travel</span>
                <h2 class="mt-3 text-[clamp(28px,3.2vw,44px)] tracking-[-.03em]">Pick the kind of holiday first</h2>
            </div>
            <div class="flex gap-2">
                <button type="button" data-rail-prev aria-label="Previous" class="rail-btn">←</button>
                <button type="button" data-rail-next aria-label="Next" class="rail-btn">→</button>
            </div>
        </div>
        <div data-rail-track class="rail">
            @foreach ($themeCards as $card)
                <a href="{{ route('packages.index', ['theme' => $card['label'], 'kind' => $card['kind']]) }}"
                   class="group relative h-[250px] w-[clamp(220px,22vw,270px)] shrink-0 snap-start overflow-hidden rounded-[24px] bg-cover bg-center transition-transform duration-300 hover:-translate-y-1.5"
                   style="background-image:url('{{ $card['img'] }}')">
                    <span class="absolute inset-0" style="background:linear-gradient(180deg,rgba(8,22,12,.05),rgba(8,22,12,.78))"></span>
                    <span class="absolute inset-x-4.5 bottom-4 block">
                        <span class="block text-[19px] font-semibold tracking-[-.015em] text-white" style="font-family:var(--font-heading)">{{ $card['label'] }}</span>
                        <span class="mt-1 block text-xs text-white/72">{{ $card['count'] }} packages</span>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured packages --}}
<section class="px-4 pt-16 sm:px-5">
    <div class="mx-auto max-w-[1400px]">
        <div class="mb-6 flex flex-wrap items-end justify-between gap-6">
            <div>
                <span class="section-kicker">Selected tours</span>
                <h2 class="mt-3 text-[clamp(28px,3.2vw,44px)] tracking-[-.03em]">Tours our guests book most</h2>
            </div>
            <a href="{{ route('packages.index') }}" class="btn btn-secondary px-5 py-3 text-[13px]">All packages</a>
        </div>
        <div class="grid grid-cols-1 gap-5.5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($featured as $package)
                @include('partials.package-card', ['package' => $package])
            @endforeach
        </div>
    </div>
</section>

{{-- Where we go --}}
<section class="px-4 pt-16 sm:px-5">
    <div class="mx-auto max-w-[1400px]">
        <div class="mb-6 flex flex-wrap items-end justify-between gap-6">
            <div>
                <span class="section-kicker">Where we go</span>
                <h2 class="mt-3 text-[clamp(28px,3.2vw,44px)] tracking-[-.03em]">Sri Lanka, and beyond it</h2>
            </div>
            <a href="{{ route('destinations') }}" class="btn btn-secondary px-5 py-3 text-[13px]">See destinations</a>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ($destinations as $destination)
                <a href="{{ route('destinations', ['kind' => $destination['kind']]) }}"
                   class="group relative h-[250px] overflow-hidden rounded-[24px] bg-cover bg-center shadow-glass transition-transform duration-300 hover:-translate-y-1.5"
                   style="background-image:url('{{ travel_img($destination['img'], 1000, 700) }}')">
                    <span class="absolute inset-0" style="background:linear-gradient(180deg,rgba(8,22,12,.06),rgba(8,22,12,.74))"></span>
                    <span class="absolute inset-x-4.5 bottom-4 block text-left">
                        <span class="block text-[11px] font-semibold tracking-[0.1em] text-white/70 uppercase">{{ $destination['kind'] }}</span>
                        <span class="mt-1.5 block text-xl font-semibold tracking-[-.015em] text-white" style="font-family:var(--font-heading)">{{ $destination['name'] }}</span>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Why Nio + testimonials --}}
<section class="px-4 pt-16 sm:px-5">
    <div class="mx-auto max-w-[1400px]">
        <div class="mb-6 max-w-[62ch]">
            <span class="section-kicker">Why Nio</span>
            <h2 class="mt-3 text-[clamp(28px,3.2vw,44px)] tracking-[-.03em]">Small enough to answer you, large enough to run it</h2>
        </div>
        <div class="mb-5.5 grid grid-cols-1 gap-4.5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($pillars as $pillar)
                <div class="glass rounded-3xl p-6.5 transition-transform duration-300 hover:-translate-y-1.5">
                    <div class="mb-4.5 grid h-11 w-11 place-items-center rounded-2xl bg-accent-100">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent-700)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $pillar['icon'] }}"/></svg>
                    </div>
                    <h4 class="mb-2 text-lg tracking-[-.015em]">{{ $pillar['title'] }}</h4>
                    <p class="text-[13.5px] leading-relaxed text-ink/60">{{ $pillar['body'] }}</p>
                </div>
            @endforeach
        </div>

        <div data-rail class="glass-strong flex flex-col gap-5.5 rounded-[30px] p-6 sm:p-9">
            <div class="flex flex-wrap items-center gap-4">
                <span class="mr-auto text-[11.5px] font-semibold tracking-[0.14em] text-accent-700 uppercase">Testimonials</span>
                <div class="flex gap-2">
                    <button type="button" data-rail-prev aria-label="Previous" class="rail-btn h-10 w-10">←</button>
                    <button type="button" data-rail-next aria-label="Next" class="rail-btn h-10 w-10">→</button>
                </div>
            </div>
            <div data-rail-track class="rail">
                @foreach ($testimonials as $quote)
                    <div class="w-full max-w-[560px] shrink-0 snap-start">
                        <span class="mb-4 block text-[15px] text-accent">★★★★★</span>
                        <blockquote class="mb-5 max-w-[34ch] text-[clamp(19px,2.2vw,26px)] leading-[1.34] font-medium tracking-[-.02em]" style="font-family:var(--font-heading)">
                            {{ $quote['text'] }}
                        </blockquote>
                        <div class="flex items-center gap-3">
                            <span class="h-11 w-11 shrink-0 rounded-full bg-[#dfe5de] bg-cover bg-center" style="background-image:url('{{ travel_img($quote['seed'], 160, 160) }}')"></span>
                            <span class="text-[13.5px] text-ink/60"><strong class="font-semibold text-ink">{{ $quote['who'] }}</strong><br>{{ $quote['meta'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- Tour albums --}}
<section class="px-4 py-16 sm:px-5" data-rail>
    <div class="mx-auto max-w-[1400px]">
        <div class="mb-6 flex flex-wrap items-end justify-between gap-6">
            <div>
                <span class="section-kicker">Tour albums</span>
                <h2 class="mt-3 text-[clamp(28px,3.2vw,44px)] tracking-[-.03em]">Photographs from recent departures</h2>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" data-rail-prev aria-label="Previous" class="rail-btn">←</button>
                <button type="button" data-rail-next aria-label="Next" class="rail-btn">→</button>
                <a href="{{ route('gallery') }}" class="btn btn-secondary ml-2 px-5 py-3 text-[13px]">Open gallery</a>
            </div>
        </div>
        <div data-rail-track class="rail">
            @foreach ($albums as $album)
                <a href="{{ route('gallery.album', $album['slug']) }}"
                   class="group relative h-[290px] w-[clamp(260px,26vw,330px)] shrink-0 snap-start overflow-hidden rounded-[26px] bg-cover bg-center transition-transform duration-300 hover:-translate-y-1.5"
                   style="background-image:url('{{ travel_img($album['seed'].'-0', 1000, 700) }}')">
                    <span class="absolute inset-0" style="background:linear-gradient(180deg,rgba(8,22,12,.05),rgba(8,22,12,.76))"></span>
                    <span class="absolute inset-x-4.5 bottom-4 block text-left">
                        <span class="block text-lg font-semibold tracking-[-.015em] text-white" style="font-family:var(--font-heading)">{{ $album['title'] }}</span>
                        <span class="mt-1 block text-xs text-white/72">{{ $album['count'] }} photos · {{ $album['when'] }}</span>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
