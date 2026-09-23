<footer class="relative z-10 bg-[rgba(14,32,20,.94)] text-white">
    <div class="mx-auto max-w-[1400px] px-4 pt-10 pb-6 sm:px-6 sm:pt-12 lg:px-8">
        <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr_1fr]">
            <div>
                <img src="{{ asset('images/logo/nio-logo.png') }}" alt="{{ config('travel.brand.name') }}" class="mb-4 h-12 w-auto brightness-0 invert">
                <p class="max-w-[36ch] text-[13.5px] leading-relaxed text-white/66">
                    {{ config('travel.brand.legal_name') }}, a travel company running inbound tours across Sri Lanka and outbound holidays worldwide.
                </p>
            </div>

            <div>
                <div class="mb-4 text-[11.5px] font-semibold tracking-[0.12em] text-accent-400 uppercase">Destinations</div>
                <div class="flex flex-col gap-2.5 text-[13.5px]">
                    <a href="{{ route('destinations', ['kind' => 'Inbound']) }}" class="text-white/78 hover:text-white">Sri Lanka</a>
                    <a href="{{ route('destinations', ['kind' => 'Outbound']) }}" class="text-white/78 hover:text-white">Maldives</a>
                    <a href="{{ route('destinations', ['kind' => 'Outbound']) }}" class="text-white/78 hover:text-white">Thailand &amp; Singapore</a>
                    <a href="{{ route('destinations', ['kind' => 'Outbound']) }}" class="text-white/78 hover:text-white">Dubai &amp; Nepal</a>
                </div>
            </div>

            <div>
                <div class="mb-4 text-[11.5px] font-semibold tracking-[0.12em] text-accent-400 uppercase">Company</div>
                <div class="flex flex-col gap-2.5 text-[13.5px]">
                    <a href="{{ route('about') }}" class="text-white/78 hover:text-white">About</a>
                    <a href="{{ route('testimonials') }}" class="text-white/78 hover:text-white">Testimonials</a>
                    <a href="{{ route('contact') }}" class="text-white/78 hover:text-white">Contact</a>
                </div>
            </div>

            <div>
                <div class="mb-4 text-[11.5px] font-semibold tracking-[0.12em] text-accent-400 uppercase">Our desks</div>
                <div class="flex flex-col gap-2 text-[13.5px] text-white/66">
                    @foreach (config('travel.contacts') as $contact)
                        <span>{{ $contact['country'] }} · {{ $contact['number'] }}</span>
                    @endforeach
                    <span>{{ config('travel.brand.email') }}</span>
                </div>
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-3 border-t border-white/12 pt-5 text-xs text-white/45 sm:flex-row sm:items-center sm:justify-between">
            <span>&copy; {{ date('Y') }} {{ config('travel.brand.legal_name') }}</span>
            <span class="flex gap-4">
                <a href="{{ route('about') }}" class="hover:text-white/70">About &amp; licences</a>
                <a href="{{ route('contact') }}" class="hover:text-white/70">Contact</a>
            </span>
        </div>
    </div>
</footer>
