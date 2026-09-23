<footer class="relative z-10 bg-[rgba(14,32,20,.94)] text-white">
    <div class="mx-auto max-w-[1400px] px-4 pt-10 pb-28 sm:px-6 sm:pt-12 lg:pb-6 lg:px-8">
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr_1fr]">
            <div>
                <img src="{{ asset('images/logo/nio-logo.png') }}" alt="{{ config('travel.brand.name') }}" class="mb-4 h-12 w-auto brightness-0 invert">
                <p class="max-w-[36ch] text-[13.5px] leading-relaxed text-white/66">
                    {{ __('site.footer.tagline', ['legal' => config('travel.brand.legal_name')]) }}
                </p>
            </div>

            <div>
                <div class="mb-4 text-[11.5px] font-semibold tracking-[0.12em] text-accent-400 uppercase">{{ __('site.footer.destinations_heading') }}</div>
                <div class="flex flex-col gap-2.5 text-[13.5px]">
                    <a href="{{ route('destinations', ['kind' => 'Inbound']) }}" class="text-white/78 hover:text-white">{{ __('site.footer.link_sri_lanka') }}</a>
                    <a href="{{ route('destinations', ['kind' => 'Outbound']) }}" class="text-white/78 hover:text-white">{{ __('site.footer.link_maldives') }}</a>
                    <a href="{{ route('destinations', ['kind' => 'Outbound']) }}" class="text-white/78 hover:text-white">{{ __('site.footer.link_thailand_singapore') }}</a>
                    <a href="{{ route('destinations', ['kind' => 'Outbound']) }}" class="text-white/78 hover:text-white">{{ __('site.footer.link_dubai_nepal') }}</a>
                </div>
            </div>

            <div>
                <div class="mb-4 text-[11.5px] font-semibold tracking-[0.12em] text-accent-400 uppercase">{{ __('site.footer.company_heading') }}</div>
                <div class="flex flex-col gap-2.5 text-[13.5px]">
                    <a href="{{ route('about') }}" class="text-white/78 hover:text-white">{{ __('site.footer.about') }}</a>
                    <a href="{{ route('testimonials') }}" class="text-white/78 hover:text-white">{{ __('site.footer.testimonials') }}</a>
                    <a href="{{ route('contact') }}" class="text-white/78 hover:text-white">{{ __('site.footer.contact') }}</a>
                </div>
            </div>

            <div>
                <div class="mb-4 text-[11.5px] font-semibold tracking-[0.12em] text-accent-400 uppercase">{{ __('site.footer.desks_heading') }}</div>
                <div class="flex flex-col gap-2 text-[13.5px] text-white/66">
                    @foreach (config('travel.contacts') as $contact)
                        <span>{{ travel_t($contact['country']) }} · {{ $contact['number'] }}</span>
                    @endforeach
                    <span>{{ config('travel.brand.email') }}</span>
                </div>
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-3 border-t border-white/12 pt-5 text-xs text-white/45 sm:flex-row sm:items-center sm:justify-between">
            <span>&copy; {{ date('Y') }} {{ config('travel.brand.legal_name') }}</span>
            <span class="flex gap-4">
                <a href="{{ route('about') }}" class="hover:text-white/70">{{ __('site.footer.about_licences') }}</a>
                <a href="{{ route('contact') }}" class="hover:text-white/70">{{ __('site.footer.contact') }}</a>
            </span>
        </div>
    </div>
</footer>
