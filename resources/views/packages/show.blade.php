@extends('layouts.app')

@section('title', $package['title'].' — '.config('travel.brand.name'))
@section('description', $package['blurb'])

@section('content')

<section class="px-3 pt-4.5 sm:px-5">
    <div class="relative mx-auto flex min-h-[min(62vh,540px)] max-w-[1400px] items-end overflow-hidden rounded-[34px] bg-[#dfe5de] bg-cover bg-center shadow-[0_40px_90px_-40px_rgba(12,34,18,.5)]"
         style="background-image:url('{{ travel_img($package['img'], 1200, 800) }}')">
        <div class="absolute inset-0" style="background:linear-gradient(180deg,rgba(8,22,12,.36),rgba(8,22,12,.84))"></div>
        <div class="relative w-full p-6 sm:p-10">
            <a href="{{ route('packages.index') }}" class="text-[13px] font-semibold text-white/80">&larr; Packages</a>
            <div class="my-4.5 flex flex-wrap gap-2">
                <span class="rounded-full border border-white/30 bg-white/16 px-3.5 py-1.5 text-xs font-semibold text-white backdrop-blur-md">{{ $package['theme'] }}</span>
                <span class="rounded-full border border-white/30 bg-white/16 px-3.5 py-1.5 text-xs font-semibold text-white backdrop-blur-md">{{ $package['where'] }}</span>
                <span class="rounded-full border border-white/30 bg-white/16 px-3.5 py-1.5 text-xs font-semibold text-white backdrop-blur-md">{{ $package['days'] }} days</span>
                <span class="rounded-full border border-white/30 bg-white/16 px-3.5 py-1.5 text-xs font-semibold text-white backdrop-blur-md">{{ $package['pax'] }}</span>
            </div>
            <h1 class="max-w-[24ch] text-[clamp(30px,4.4vw,62px)] leading-[1.02] tracking-[-.035em] text-white">{{ $package['title'] }}</h1>
        </div>
    </div>
</section>

<section class="px-4 pt-9 pb-10 sm:px-5">
    <div class="mx-auto grid max-w-[1400px] grid-cols-1 items-start gap-8 lg:grid-cols-[minmax(0,1fr)_360px]">

        <div>
            {{-- Day by day --}}
            <div class="glass-strong mb-6 rounded-[30px] p-6 sm:p-9">
                <h2 class="mb-1.5 text-[clamp(24px,2.4vw,34px)] tracking-[-.025em]">Day by day</h2>
                <p class="mb-5.5 text-sm text-ink/45">A sample shape for this tour, we rewrite it around your dates, pace and party.</p>

                @foreach ($itinerary as $day)
                    <details class="group mb-2.5 overflow-hidden rounded-[20px] bg-white/55 open:bg-accent-100" @if($day['n'] === 3) open @endif>
                        <summary class="flex cursor-pointer list-none items-center gap-4 px-5 py-4.5 marker:content-['']">
                            <span class="grid h-9 w-9 shrink-0 place-items-center rounded-xl bg-black/5 text-[13px] font-semibold group-open:bg-accent group-open:text-white" style="font-family:var(--font-heading)">{{ $day['n'] }}</span>
                            <span class="flex-1 text-[17.5px] font-semibold tracking-[-.015em]" style="font-family:var(--font-heading)">{{ $day['title'] }}</span>
                            <span class="shrink-0 text-xl font-bold text-accent-700 transition-transform group-open:rotate-45">+</span>
                        </summary>
                        <div class="px-5 pt-0 pb-5.5 pl-[72px]">
                            <p class="mb-3.5 max-w-[70ch] text-[14.5px] leading-relaxed text-ink/60">{{ $day['body'] }}</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="rounded-full bg-white px-3.5 py-1.5 text-xs font-semibold">{{ $day['stay'] }}</span>
                                <span class="rounded-full bg-white px-3.5 py-1.5 text-xs font-semibold">{{ $day['meals'] }}</span>
                            </div>
                        </div>
                    </details>
                @endforeach
            </div>

            {{-- Included / excluded --}}
            <div class="glass-strong mb-6 rounded-[30px] p-6 sm:p-9">
                <h2 class="mb-4.5 text-[clamp(22px,2.2vw,30px)] tracking-[-.025em]">Included &amp; excluded</h2>
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    @foreach ($inclusions as $inclusion)
                        <div class="flex items-start gap-3 rounded-2xl p-4 {{ $inclusion['included'] ? 'bg-accent-100' : 'bg-black/[.04]' }}">
                            <span class="grid h-5.5 w-5.5 shrink-0 place-items-center rounded-full text-xs font-bold text-white {{ $inclusion['included'] ? 'bg-accent' : 'bg-ink/35' }}">
                                {{ $inclusion['included'] ? '✓' : '–' }}
                            </span>
                            <span>
                                <span class="block text-sm font-bold">{{ $inclusion['item'] }}</span>
                                <span class="mt-0.5 block text-[12.5px] text-ink/60">{{ $inclusion['note'] }}</span>
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Gallery strip --}}
            <div class="grid grid-cols-2 gap-3.5 sm:grid-cols-4">
                @foreach ($detailShots as $shot)
                    <div class="h-[150px] rounded-[22px] bg-[#dfe5de] bg-cover bg-center" style="background-image:url('{{ $shot }}')"></div>
                @endforeach
            </div>
        </div>

        {{-- Sticky enquiry sidebar --}}
        <aside class="glass-strong sticky top-[104px] rounded-[30px] p-6.5">
            <span class="text-[11.5px] font-semibold tracking-[0.12em] text-accent-700 uppercase">Quote on enquiry</span>
            <p class="mt-3 mb-5.5 text-[14.5px] leading-relaxed text-ink/60">Tell us your dates and party and we send a written quote the same working day.</p>
            <a href="{{ route('contact', ['interest' => $package['theme'], 'package' => $package['title']]) }}" class="btn btn-primary mb-2.5 w-full px-5 py-4 text-[13.5px]">Request a quote</a>
            <button type="button" data-wa-open class="btn btn-secondary w-full px-5 py-4 text-[13.5px]">WhatsApp us</button>
            <div class="my-6 h-px bg-divider"></div>
            <div class="mb-3 text-[11.5px] font-semibold tracking-[0.12em] text-ink/45 uppercase">Best season</div>
            <p class="text-[13.5px] leading-relaxed text-ink/60">{{ $package['season'] }}</p>
        </aside>
    </div>
</section>

{{-- Sticky bottom CTA bar --}}
<div class="sticky bottom-4 z-40 px-4 sm:px-5">
    <div class="mx-auto flex max-w-[1400px] flex-wrap items-center gap-4.5 rounded-full border border-white/16 bg-[rgba(14,32,20,.72)] py-3 pr-5 pl-6.5 backdrop-blur-xl">
        <div class="mr-auto">
            <div class="text-[15px] font-semibold text-white" style="font-family:var(--font-heading)">{{ $package['title'] }}</div>
            <div class="mt-0.5 text-xs text-white/62">{{ $package['days'] }} days · {{ $package['where'] }} · Quote on enquiry</div>
        </div>
        <button type="button" data-wa-open class="btn border border-white/30 bg-white/14 px-5 py-3.5 text-[13px] text-white">WhatsApp</button>
        <a href="{{ route('contact', ['interest' => $package['theme'], 'package' => $package['title']]) }}" class="btn btn-primary px-5.5 py-3.5 text-[13px]">Request a quote</a>
    </div>
</div>

@endsection
