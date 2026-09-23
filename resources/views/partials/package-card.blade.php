@php $package ??= null; @endphp
<article class="glass-strong flex flex-col overflow-hidden rounded-[28px] transition-transform duration-300 hover:-translate-y-2">
    <a href="{{ route('packages.show', $package['slug']) }}" class="relative block h-[210px] bg-[#dfe5de] bg-cover bg-center" style="background-image:url('{{ travel_img($package['img'], 1000, 700) }}')">
        <span class="absolute top-4 left-4 rounded-full bg-white/85 px-3.5 py-1.5 text-[11.5px] font-bold tracking-[0.05em] text-accent-800 uppercase backdrop-blur-md">
            {{ travel_label(config('travel.theme_labels'), $package['theme']) }}
        </span>
        <span class="absolute bottom-3.5 left-4 rounded-full bg-[rgba(10,24,14,.5)] px-3 py-1.5 text-xs font-semibold text-white backdrop-blur-md">
            {{ travel_t($package['where']) }}
        </span>
    </a>
    <div class="flex flex-1 flex-col p-6">
        <h3 class="mb-2.5 text-xl">{{ travel_t($package['title']) }}</h3>
        <p class="mb-4 flex-1 text-[13.5px] leading-relaxed text-ink/60">{{ travel_t($package['blurb']) }}</p>
        <div class="mb-5 flex flex-wrap gap-2">
            <span class="rounded-full bg-black/5 px-3.5 py-1.5 text-xs font-semibold">{{ $package['days'] }} {{ __('site.common.days') }}</span>
            <span class="rounded-full bg-black/5 px-3.5 py-1.5 text-xs font-semibold">{{ $package['pax'] }}</span>
        </div>
        <div class="flex flex-wrap gap-2.5">
            <a href="{{ route('packages.show', $package['slug']) }}" class="btn btn-primary px-4.5 py-3 text-[12.5px]">{{ __('site.packages.itinerary_btn') }}</a>
            <button type="button" data-wa-open class="btn btn-secondary px-4.5 py-3 text-[12.5px]">{{ __('site.common.whatsapp') }}</button>
        </div>
    </div>
</article>
