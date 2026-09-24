@php
    $heroCtas = $ctas ?? [];
@endphp
<section class="relative -mt-16 flex min-h-[400px] items-end sm:-mt-20 sm:min-h-[560px] overflow-hidden bg-[#dfe5de] bg-cover bg-center"
     style="background-image:url('{{ travel_img($image, 1920, 900, $keywords ?? null) }}')">
    <div class="absolute inset-0" style="background:linear-gradient(180deg,rgba(8,22,12,.32) 0%,rgba(8,22,12,.18) 32%,rgba(8,22,12,.86) 100%)"></div>
    <div class="relative mx-auto w-full max-w-[1400px] px-4 pt-8 pb-10 sm:px-6 sm:py-10 lg:px-8 lg:py-12">
        <span class="text-xs font-semibold tracking-[0.14em] text-white/85 uppercase">{{ $kicker }}</span>
        <h1 class="mt-4 max-w-[26ch] text-[clamp(30px,4.6vw,58px)] leading-[1.04] tracking-[-.035em] text-white">{{ $title }}</h1>
        @isset($subtitle)
            <p class="mt-4 max-w-[62ch] text-[15px] leading-relaxed text-white/80 sm:text-[16.5px]">{{ $subtitle }}</p>
        @endisset
        @if (count($heroCtas))
            <div class="mt-6 flex flex-wrap gap-3">
                @foreach ($heroCtas as $cta)
                    <a href="{{ $cta['href'] }}" class="btn {{ ($cta['style'] ?? 'dark') === 'primary' ? 'btn-primary' : 'btn-dark' }} px-6 py-3.5 text-sm max-sm:flex-1">{{ $cta['label'] }}</a>
                @endforeach
            </div>
        @endif
    </div>
</section>
