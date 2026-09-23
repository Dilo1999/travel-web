@extends('layouts.app')

@section('title', __('site.about.meta_title').' — '.config('travel.brand.name'))
@section('description', travel_t(config('travel.brand.founded_copy')))

@section('content')

@include('partials.page-hero', [
    'kicker' => config('travel.brand.legal_name'),
    'title' => __('site.about.hero_title'),
    'subtitle' => __('site.about.hero_subtitle'),
    'image' => 'niohero-about',
    'keywords' => 'Colombo,Sri Lanka',
])

<section class="px-4 pt-10 sm:px-5">
    <div class="mx-auto grid max-w-[1400px] grid-cols-1 items-center gap-10 lg:grid-cols-[1.15fr_1fr]">
        <div>
            <span class="section-kicker">{{ __('site.about.story_kicker') }}</span>
            <h2 class="mt-4 mb-5 text-[clamp(26px,3vw,40px)] tracking-[-.03em]">{{ __('site.about.story_heading') }}</h2>
            <p class="max-w-[56ch] text-[16.5px] leading-relaxed text-ink/60">{{ travel_t(config('travel.brand.founded_copy')) }}</p>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="h-[200px] rounded-[26px] bg-[#dfe5de] bg-cover bg-center" style="background-image:url('{{ travel_img('nioab1', 700, 700, 'landscape') }}')"></div>
            <div class="mt-7 h-[200px] rounded-[26px] bg-[#dfe5de] bg-cover bg-center" style="background-image:url('{{ travel_img('nioab2', 700, 700, 'kandy') }}')"></div>
            <div class="h-[200px] rounded-[26px] bg-[#dfe5de] bg-cover bg-center" style="background-image:url('{{ travel_img('nioab3', 700, 700, 'nuwara eliya') }}')"></div>
            <div class="mt-7 h-[200px] rounded-[26px] bg-[#dfe5de] bg-cover bg-center" style="background-image:url('{{ travel_img('nioab4', 700, 700, 'jeep') }}')"></div>
        </div>
    </div>
</section>

<section class="px-4 pt-14 sm:px-5">
    <div class="mx-auto max-w-[1400px]">
        <div class="mb-6.5">
            <span class="section-kicker">{{ __('site.about.team_kicker') }}</span>
            <h2 class="mt-3 text-[clamp(26px,3vw,40px)] tracking-[-.03em]">{{ __('site.about.team_heading') }}</h2>
        </div>
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($staff as $member)
                <div class="glass-strong overflow-hidden rounded-[26px] transition-transform duration-300 hover:-translate-y-1.5">
                    <div class="h-[230px] bg-[#dfe5de] bg-cover bg-center" style="background-image:url('{{ travel_img($member['seed'], 700, 800, 'portrait,professional') }}')"></div>
                    <div class="px-5.5 pt-5 pb-5.5">
                        <div class="text-[17px] font-semibold tracking-[-.015em]" style="font-family:var(--font-heading)">{{ $member['name'] }}</div>
                        <div class="mt-1 text-[12.5px] font-semibold text-accent-700">{{ travel_t($member['role']) }}</div>
                        <div class="mt-2 text-[12.5px] text-ink/45">{{ travel_t($member['note']) }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="px-4 py-14 sm:px-5">
    <div class="glass-strong mx-auto max-w-[1400px] rounded-[30px] p-6 sm:p-9">
        <h2 class="mb-4.5 text-[clamp(22px,2.2vw,30px)] tracking-[-.025em]">{{ __('site.about.licences_heading') }}</h2>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[560px] border-collapse text-left">
                <thead>
                    <tr class="border-b border-divider text-[13px] text-ink/60">
                        <th class="py-3 pr-4 font-medium">{{ __('site.about.table_registration') }}</th>
                        <th class="py-3 pr-4 font-medium">{{ __('site.about.table_body') }}</th>
                        <th class="py-3 pr-4 font-medium">{{ __('site.about.table_reference') }}</th>
                        <th class="py-3 font-medium">{{ __('site.about.table_status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($licences as $licence)
                        <tr class="border-b border-divider">
                            <td class="py-3.5 pr-4 text-sm font-bold">{{ $licence['registration'] }}</td>
                            <td class="py-3.5 pr-4 text-sm text-ink/60">{{ $licence['body'] }}</td>
                            <td class="py-3.5 pr-4 text-sm text-ink/60">{{ $licence['reference'] }}</td>
                            <td class="py-3.5">
                                <span class="rounded-full px-3 py-1.5 text-xs font-semibold {{ $licence['status']['en'] === 'Active' ? 'bg-accent-100 text-accent-800' : 'bg-black/5 text-ink/60' }}">
                                    {{ travel_t($licence['status']) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection
