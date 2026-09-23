@php $destination ??= null; @endphp
<article class="glass-strong flex flex-col overflow-hidden rounded-[28px] transition-transform duration-300 hover:-translate-y-2">
    <div class="relative h-[210px] bg-[#dfe5de] bg-cover bg-center" style="background-image:url('{{ travel_img($destination['img'], 1000, 700) }}')">
        <span class="absolute top-4 left-4 rounded-full bg-white/85 px-3.5 py-1.5 text-[11.5px] font-bold tracking-[0.05em] text-accent-800 uppercase backdrop-blur-md">
            {{ travel_label(config('travel.kind_labels'), $destination['kind']) }}
        </span>
    </div>
    <div class="flex flex-1 flex-col p-6">
        <h3 class="mb-1 text-[22px]">{{ travel_t($destination['name']) }}</h3>
        <div class="mb-3 text-[12.5px] text-ink/45">{{ travel_label(config('travel.country_labels'), $destination['country']) }}</div>
        <p class="mb-4 flex-1 text-[13.5px] leading-relaxed text-ink/60">{{ travel_t($destination['blurb']) }}</p>
        <div class="mb-4.5 flex flex-wrap gap-2">
            @foreach ($destination['tags'] as $tag)
                <span class="rounded-full bg-accent-100 px-3 py-1.5 text-[11.5px] font-semibold text-accent-800">{{ travel_label(config('travel.tag_labels'), $tag) }}</span>
            @endforeach
        </div>
        <a href="{{ route('packages.index', ['kind' => $destination['kind']]) }}" class="btn btn-primary self-start px-4.5 py-3 text-[12.5px]">{{ __('site.destinations.see_packages') }}</a>
    </div>
</article>
