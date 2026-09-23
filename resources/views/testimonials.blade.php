@extends('layouts.app')

@section('title', __('site.testimonials.meta_title').' — '.config('travel.brand.name'))
@section('description', __('site.testimonials.meta_description', ['brand' => config('travel.brand.name')]))

@section('content')

<section class="px-4 pt-11 pb-6.5 sm:px-5">
    <div class="mx-auto max-w-[1400px]">
        <span class="section-kicker">{{ __('site.testimonials.kicker') }}</span>
        <h1 class="mt-4 text-[clamp(34px,4.6vw,64px)] leading-[1] tracking-[-.035em]">{{ __('site.testimonials.heading') }}</h1>
    </div>
</section>

<section class="px-4 pb-16 sm:px-5">
    <div class="mx-auto grid max-w-[1400px] grid-cols-1 gap-5.5 sm:grid-cols-2">
        @foreach ($testimonials as $quote)
            <div class="glass-strong flex flex-col rounded-[28px] p-7.5">
                <span class="mb-3.5 text-sm text-accent">★★★★★</span>
                <blockquote class="mb-5.5 flex-1 text-[clamp(18px,1.6vw,23px)] leading-[1.32] font-semibold tracking-[-.02em]" style="font-family:var(--font-heading)">
                    {{ travel_t($quote['text']) }}
                </blockquote>
                <div class="flex items-center gap-3">
                    <span class="h-11 w-11 shrink-0 rounded-full bg-[#dfe5de] bg-cover bg-center" style="background-image:url('{{ travel_img($quote['seed'], 160, 160, 'portrait,person') }}')"></span>
                    <div class="flex-1">
                        <div class="text-sm font-bold">{{ $quote['who'] }}</div>
                        <div class="mt-0.5 text-xs text-ink/45">{{ $quote['meta'] }}</div>
                    </div>
                    <span class="rounded-full bg-accent-100 px-3 py-1.5 text-[11.5px] font-bold text-accent-800">{{ travel_t($quote['tour']) }}</span>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection
