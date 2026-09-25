@extends('layouts.app')

@section('title', travel_t(config('travel.brand.tagline')).' — '.config('travel.brand.name'))

@section('content')

{{-- Hero --}}
<section class="relative -mt-16 flex h-[82svh] min-h-[460px] items-end overflow-hidden sm:-mt-20 sm:h-screen sm:min-h-[560px]">
    <div class="animate-hero-video absolute inset-0 bg-[#0c1a10] bg-cover bg-center" style="background-image:url('{{ travel_img('niohero3', 1920, 1080, 'Sri Lanka,coast') }}')"></div>
    <div class="absolute inset-0" style="background:linear-gradient(180deg,rgba(8,22,12,.50) 0%,rgba(8,22,12,.10) 34%,rgba(8,22,12,.80) 100%)"></div>

    <div class="relative mx-auto w-full max-w-[1440px] px-5 pt-16 pb-28 sm:px-10 sm:pb-20">
        <div class="animate-hero mb-5 inline-flex items-center gap-2.5 rounded-full border border-white/30 bg-white/16 px-3.5 py-1.5 backdrop-blur-md sm:mb-6 sm:px-4 sm:py-2">
            <span class="h-[7px] w-[7px] rounded-full bg-[#7ee08f] shadow-[0_0_12px_#7ee08f]"></span>
            <span class="text-xs font-semibold tracking-[0.06em] text-white uppercase">{{ __('site.home.hero_badge') }}</span>
        </div>
        <h1 class="animate-hero mb-5 max-w-[19ch] text-[clamp(38px,5.6vw,84px)] leading-[1] tracking-[-.035em] text-white text-balance">
            {{ travel_t(config('travel.brand.tagline')) }}
        </h1>
        <p class="animate-hero mb-7 max-w-[58ch] text-[clamp(15px,1.3vw,19px)] leading-relaxed text-white/88">
            {{ __('site.home.hero_subtitle') }}
        </p>
        <div class="animate-hero flex flex-wrap gap-3 max-sm:flex-col">
            <a href="{{ route('packages.index') }}" class="btn btn-primary px-6.5 py-4 text-sm">{{ __('site.home.browse_packages') }}</a>
            <a href="{{ route('destinations') }}" class="btn btn-dark px-6.5 py-4 text-sm">{{ __('site.home.see_destinations') }}</a>
        </div>
    </div>
</section>

{{-- Ways to travel --}}
<section class="px-4 pt-16 sm:px-5" data-rail>
    <div class="mx-auto max-w-[1400px]">
        <div class="mb-6 flex flex-wrap items-end justify-between gap-6">
            <div>
                <span class="section-kicker">{{ __('site.home.ways_kicker') }}</span>
                <h2 class="mt-3 text-[clamp(28px,3.2vw,44px)] tracking-[-.03em]">{{ __('site.home.ways_heading') }}</h2>
            </div>
            <div class="flex gap-2">
                <button type="button" data-rail-prev aria-label="{{ __('site.common.previous') }}" class="rail-btn">←</button>
                <button type="button" data-rail-next aria-label="{{ __('site.common.next') }}" class="rail-btn">→</button>
            </div>
        </div>
        <div data-rail-track class="rail">
            @foreach ($themeCards as $card)
                <a href="{{ route('packages.index', ['theme' => $card['key'], 'kind' => $card['kind']]) }}"
                   class="group relative h-[220px] w-[clamp(220px,22vw,270px)] shrink-0 snap-start overflow-hidden rounded-[20px] bg-cover bg-center transition-transform duration-300 hover:-translate-y-1.5 sm:h-[250px] sm:rounded-[24px]"
                   style="background-image:url('{{ $card['img'] }}')">
                    <span class="absolute inset-0" style="background:linear-gradient(180deg,rgba(8,22,12,.05),rgba(8,22,12,.78))"></span>
                    <span class="absolute inset-x-4.5 bottom-4 block">
                        <span class="block text-[19px] font-semibold tracking-[-.015em] text-white" style="font-family:var(--font-heading)">{{ $card['label'] }}</span>
                        <span class="mt-1 block text-xs text-white/72">{{ $card['count'] }} {{ __('site.common.packages_count') }}</span>
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
                <span class="section-kicker">{{ __('site.home.selected_kicker') }}</span>
                <h2 class="mt-3 text-[clamp(28px,3.2vw,44px)] tracking-[-.03em]">{{ __('site.home.selected_heading') }}</h2>
            </div>
            <a href="{{ route('packages.index') }}" class="btn btn-secondary px-5 py-3 text-[13px]">{{ __('site.home.all_packages') }}</a>
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
                <span class="section-kicker">{{ __('site.home.where_kicker') }}</span>
                <h2 class="mt-3 text-[clamp(28px,3.2vw,44px)] tracking-[-.03em]">{{ __('site.home.where_heading') }}</h2>
            </div>
            <a href="{{ route('destinations') }}" class="btn btn-secondary px-5 py-3 text-[13px]">{{ __('site.home.see_destinations') }}</a>
        </div>
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 sm:gap-4 lg:grid-cols-5">
            @foreach ($destinations as $destination)
                <a href="{{ $destination->packagesUrl() }}"
                   class="group relative h-[190px] overflow-hidden rounded-[20px] bg-cover bg-center shadow-glass transition-transform duration-300 hover:-translate-y-1.5 sm:h-[250px] sm:rounded-[24px] {{ $loop->last && $loop->count % 2 === 1 ? 'max-sm:col-span-2' : '' }}"
                   style="background-image:url('{{ $destination->heroImageUrl(1000, 700) }}')">
                    <span class="absolute inset-0" style="background:linear-gradient(180deg,rgba(8,22,12,.06),rgba(8,22,12,.74))"></span>
                    <span class="absolute inset-x-3.5 bottom-3.5 block text-left sm:inset-x-4.5 sm:bottom-4">
                        <span class="block text-[10px] font-semibold tracking-[0.1em] text-white/70 uppercase sm:text-[11px]">{{ travel_label(config('travel.kind_labels'), $destination['kind']) }}</span>
                        <span class="mt-1 block text-base font-semibold tracking-[-.015em] text-white sm:mt-1.5 sm:text-xl" style="font-family:var(--font-heading)">{{ travel_t($destination['name']) }}</span>
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
            <span class="section-kicker">{{ __('site.home.why_kicker') }}</span>
            <h2 class="mt-3 text-[clamp(28px,3.2vw,44px)] tracking-[-.03em]">{{ __('site.home.why_heading') }}</h2>
        </div>
        <div class="mb-5.5 grid grid-cols-1 gap-4.5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($pillars as $pillar)
                <div class="glass rounded-3xl p-6.5 transition-transform duration-300 hover:-translate-y-1.5 max-sm:flex max-sm:items-start max-sm:gap-4 max-sm:p-5">
                    <div class="mb-4.5 grid h-11 w-11 shrink-0 place-items-center rounded-2xl bg-accent-100 max-sm:mb-0">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="var(--color-accent-700)" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $pillar['icon'] }}"/></svg>
                    </div>
                    <div>
                        <h4 class="mb-2 text-lg tracking-[-.015em] max-sm:mb-1 max-sm:text-[17px]">{{ travel_t($pillar['title']) }}</h4>
                        <p class="text-[13.5px] leading-relaxed text-ink/60">{{ travel_t($pillar['body']) }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div data-rail class="glass-strong flex flex-col gap-5.5 rounded-[24px] p-5 sm:rounded-[30px] sm:p-9">
            <div class="flex flex-wrap items-center gap-4">
                <span class="mr-auto text-[11.5px] font-semibold tracking-[0.14em] text-accent-700 uppercase">{{ __('site.home.testimonials_kicker') }}</span>
                <div class="flex gap-2">
                    <button type="button" data-rail-prev aria-label="{{ __('site.common.previous') }}" class="rail-btn h-10 w-10">←</button>
                    <button type="button" data-rail-next aria-label="{{ __('site.common.next') }}" class="rail-btn h-10 w-10">→</button>
                </div>
            </div>
            <div data-rail-track class="rail">
                @foreach ($testimonials as $quote)
                    <div class="w-full max-w-[560px] shrink-0 snap-start">
                        <span class="mb-4 block text-[15px] text-accent">★★★★★</span>
                        <blockquote class="mb-5 max-w-[34ch] text-[clamp(19px,2.2vw,26px)] leading-[1.34] font-medium tracking-[-.02em]" style="font-family:var(--font-heading)">
                            {{ travel_t($quote['text']) }}
                        </blockquote>
                        <div class="flex items-center gap-3">
                            <span class="h-11 w-11 shrink-0 rounded-full bg-[#dfe5de] bg-cover bg-center" style="background-image:url('{{ travel_img($quote['seed'], 160, 160, 'portrait,person') }}')"></span>
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
                <span class="section-kicker">{{ __('site.home.albums_kicker') }}</span>
                <h2 class="mt-3 text-[clamp(28px,3.2vw,44px)] tracking-[-.03em]">{{ __('site.home.albums_heading') }}</h2>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" data-rail-prev aria-label="{{ __('site.common.previous') }}" class="rail-btn">←</button>
                <button type="button" data-rail-next aria-label="{{ __('site.common.next') }}" class="rail-btn">→</button>
                <a href="{{ route('gallery') }}" class="btn btn-secondary ml-2 px-5 py-3 text-[13px]">{{ __('site.home.open_gallery') }}</a>
            </div>
        </div>
        <div data-rail-track class="rail">
            @foreach ($albums as $album)
                <a href="{{ route('gallery.album', $album['slug']) }}"
                   class="group relative h-[250px] w-[clamp(260px,26vw,330px)] shrink-0 snap-start overflow-hidden rounded-[20px] bg-cover bg-center transition-transform duration-300 hover:-translate-y-1.5 sm:h-[290px] sm:rounded-[26px]"
                   style="background-image:url('{{ travel_img($album['seed'].'-0', 1000, 700, $album['where']) }}')">
                    <span class="absolute inset-0" style="background:linear-gradient(180deg,rgba(8,22,12,.05),rgba(8,22,12,.76))"></span>
                    <span class="absolute inset-x-4.5 bottom-4 block text-left">
                        <span class="block text-lg font-semibold tracking-[-.015em] text-white" style="font-family:var(--font-heading)">{{ travel_t($album['title']) }}</span>
                        <span class="mt-1 block text-xs text-white/72">{{ $album['count'] }} {{ __('site.common.photos') }} · {{ $album['when'] }}</span>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>

@endsection
