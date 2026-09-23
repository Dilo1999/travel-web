@extends('layouts.app')

@section('title', $album['title'].' — Gallery — '.config('travel.brand.name'))
@section('description', $album['title'].' — '.$album['where'].', '.$album['when'].'.')

@section('content')

<section class="px-4 pt-11 sm:px-5">
    <div class="mx-auto max-w-[1400px]">
        <a href="{{ route('gallery') }}" class="text-[13px] font-semibold text-ink/60 hover:text-ink">&larr; Gallery</a>
        <div class="mt-4 flex flex-wrap items-end justify-between gap-4">
            <div>
                <span class="section-kicker">{{ $album['theme'] }}</span>
                <h1 class="mt-3 text-[clamp(26px,3.4vw,46px)] tracking-[-.03em]">{{ $album['title'] }}</h1>
                <p class="mt-2 text-[13px] text-ink/45">{{ $album['where'] }} · {{ $album['when'] }} · {{ $album['count'] }} photos</p>
            </div>
        </div>
    </div>
</section>

<section class="px-4 py-7 sm:px-5 sm:py-9">
    <div class="mx-auto max-w-[1200px] columns-1 gap-4 sm:columns-2 lg:columns-3">
        @foreach ($shots as $shot)
            <div class="mb-4 break-inside-avoid rounded-[20px] bg-[#22301f] bg-cover bg-center" style="height:{{ $shot['height'] }}px;background-image:url('{{ $shot['img'] }}')"></div>
        @endforeach
    </div>
</section>

@endsection
