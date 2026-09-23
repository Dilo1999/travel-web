@php
    $heroCtas = $ctas ?? [];
@endphp
<section class="px-3 pt-4.5 sm:px-5">
    <div class="relative mx-auto flex min-h-[300px] max-w-[1400px] items-end overflow-hidden rounded-[34px] bg-[#dfe5de] bg-cover bg-center shadow-[0_40px_90px_-40px_rgba(12,34,18,.5)] sm:min-h-[380px]"
         style="background-image:url('{{ travel_img($image, 1600, 900) }}')">
        <div class="absolute inset-0" style="background:linear-gradient(180deg,rgba(8,22,12,.32) 0%,rgba(8,22,12,.18) 32%,rgba(8,22,12,.86) 100%)"></div>
        <div class="relative w-full p-6 sm:p-10 lg:p-12">
            <span class="text-xs font-semibold tracking-[0.14em] text-white/85 uppercase">{{ $kicker }}</span>
            <h1 class="mt-4 max-w-[26ch] text-[clamp(30px,4.6vw,58px)] leading-[1.04] tracking-[-.035em] text-white">{{ $title }}</h1>
            @isset($subtitle)
                <p class="mt-4 max-w-[62ch] text-[15px] leading-relaxed text-white/80 sm:text-[16.5px]">{{ $subtitle }}</p>
            @endisset
            @if (count($heroCtas))
                <div class="mt-6 flex flex-wrap gap-3">
                    @foreach ($heroCtas as $cta)
                        <a href="{{ $cta['href'] }}" class="btn {{ ($cta['style'] ?? 'dark') === 'primary' ? 'btn-primary' : 'btn-dark' }} px-6 py-3.5 text-sm">{{ $cta['label'] }}</a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
