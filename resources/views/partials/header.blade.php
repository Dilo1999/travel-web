@php
    $isHome = request()->routeIs('home');
    // Pages that open with a full-width image hero — the header can start
    // transparent over it and turn solid glass once the page is scrolled.
    $heroRoutes = ['home', 'destinations', 'packages.index', 'packages.show', 'gallery', 'about', 'contact'];
    $hasHero = collect($heroRoutes)->contains(fn ($route) => request()->routeIs($route));
    $navLinks = [
        ['label' => __('site.nav.home'), 'route' => 'home', 'active' => request()->routeIs('home')],
        ['label' => __('site.nav.destinations'), 'route' => 'destinations', 'active' => request()->routeIs('destinations')],
        ['label' => __('site.nav.packages'), 'route' => 'packages.index', 'active' => request()->routeIs('packages.*')],
        ['label' => __('site.nav.gallery'), 'route' => 'gallery', 'active' => request()->routeIs('gallery*')],
        ['label' => __('site.nav.about'), 'route' => 'about', 'active' => request()->routeIs('about')],
        ['label' => __('site.nav.contact'), 'route' => 'contact', 'active' => request()->routeIs('contact')],
    ];
    $localeLabels = ['en' => 'EN', 'hi' => 'हिंदी', 'ta' => 'தமிழ்'];
    $localeShort = ['en' => 'EN', 'hi' => 'हिं', 'ta' => 'த'];
    $bottomNavLinks = collect($navLinks)->whereIn('route', ['home', 'packages.index', 'gallery', 'contact'])->values();
@endphp

<header class="site-header sticky top-0 z-50">
    <div
        data-nav-bar
        @if($hasHero) data-transparent-hero @endif
        class="relative transition-colors duration-300 {{ $hasHero ? '' : 'header-bar text-ink' }}"
    >
        <div class="mx-auto flex h-16 max-w-[1400px] items-center gap-1 px-4 sm:h-20 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="mr-auto flex items-center">
                <img data-nav-logo src="{{ asset('images/logo/nio-logo.png') }}" alt="{{ config('travel.brand.name') }}" class="h-11 w-auto transition-[filter] duration-300 sm:h-16">
            </a>

            <nav class="hidden items-center gap-0.5 lg:flex">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="rounded-full px-3 py-2 text-[12.5px] font-semibold whitespace-nowrap transition hover:bg-white/20 {{ $link['active'] ? 'underline decoration-2 underline-offset-4' : '' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="ml-1 hidden items-center gap-0.5 rounded-full border border-white/25 bg-white/10 p-1 lg:flex">
                @foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $code => $properties)
                    <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($code, null, [], true) }}"
                       @if(app()->getLocale() === $code) style="color: var(--color-ink)" @endif
                       class="rounded-full px-3 py-1.5 text-[12px] font-semibold whitespace-nowrap transition {{ app()->getLocale() === $code ? 'bg-white' : 'text-white/85 hover:bg-white/15' }}">
                        {{ $localeLabels[$code] ?? strtoupper($code) }}
                    </a>
                @endforeach
            </div>

            <a href="{{ route('contact') }}" class="btn btn-primary ml-4 hidden px-4 py-2.5 text-[12.5px] sm:inline-flex">
                {{ __('site.nav.enquire') }}
            </a>

            <div class="ml-2 flex items-center gap-1 text-[12.5px] font-semibold lg:hidden">
                @foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $code => $properties)
                    @if (!$loop->first)<span class="opacity-40">&middot;</span>@endif
                    <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($code, null, [], true) }}"
                       class="{{ app()->getLocale() === $code ? '' : 'opacity-60 hover:opacity-100' }}">
                        {{ $localeShort[$code] ?? strtoupper($code) }}
                    </a>
                @endforeach
            </div>

            <button data-mobile-menu-toggle type="button" aria-expanded="false" aria-label="{{ __('site.nav.open_menu') }}"
                    class="ml-1 grid h-10 w-10 shrink-0 place-items-center rounded-full transition hover:bg-white/20 lg:hidden">
                <svg data-mobile-menu-icon="open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg data-mobile-menu-icon="close" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="hidden"><path d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        </div>

        {{-- Scroll progress bar: fills as the page is scrolled, hidden at the very top --}}
        <div data-scroll-progress
             class="pointer-events-none absolute inset-x-0 bottom-0 h-[3px] origin-left scale-x-0 bg-accent opacity-0 transition-[transform,opacity] duration-150 ease-out"></div>
    </div>
</header>

{{-- Mobile nav overlay --}}
<div data-mobile-menu-overlay
     class="fixed inset-0 z-40 translate-x-full overflow-y-auto bg-canvas opacity-0 pointer-events-none transition-all duration-300 lg:hidden">
    <div class="flex min-h-screen flex-col px-5 pt-20 pb-10 sm:px-6 sm:pt-24">
        <nav class="flex flex-col gap-1.5">
            @foreach ($navLinks as $link)
                <a data-mobile-menu-close href="{{ route($link['route']) }}"
                   class="flex items-center justify-between rounded-2xl px-4 py-4 text-lg font-semibold {{ $link['active'] ? 'bg-accent-100 text-accent-800' : 'active:bg-black/5 hover:bg-black/5' }}">
                    {{ $link['label'] }}
                    <svg class="opacity-40 sm:hidden" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 6l6 6-6 6"/></svg>
                </a>
            @endforeach
        </nav>
        <div class="mt-6 flex items-center gap-1 self-start rounded-full border border-divider bg-black/[.03] p-1">
            @foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $code => $properties)
                <a href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($code, null, [], true) }}"
                   class="rounded-full px-3.5 py-2 text-[13px] font-semibold whitespace-nowrap transition {{ app()->getLocale() === $code ? 'bg-accent text-white' : 'text-ink/70' }}">
                    {{ $localeLabels[$code] ?? strtoupper($code) }}
                </a>
            @endforeach
        </div>
        <a data-mobile-menu-close href="{{ route('contact') }}" class="btn btn-primary mt-4 justify-center py-4 text-sm">
            {{ __('site.nav.enquire_now') }}
        </a>
    </div>
</div>

{{-- Bottom tab bar (mobile only): icon + label, docked with safe-area padding --}}
@php
    $tabIcons = [
        'home' => 'M3 11.5 12 4l9 7.5M5.5 10v9.5h4.5v-5h4v5h4.5V10',
        'packages.index' => 'M4 7.5 12 4l8 3.5v9L12 20l-8-3.5v-9ZM4 7.5l8 3.5m0 0 8-3.5M12 11v9',
        'gallery' => 'M4 5h16v14H4V5Zm0 11 4.5-4.5 3.5 3.5 3-3 5 5M15.5 9.5h.01',
        'contact' => 'M4 6h16v12H4V6Zm0 1 8 6.5L20 7',
    ];
@endphp
<nav class="fixed inset-x-3 bottom-3 z-30 lg:hidden" style="bottom:max(12px,env(safe-area-inset-bottom))">
    <div class="mx-auto flex max-w-[420px] items-stretch rounded-[22px] border border-black/5 bg-white/92 p-1.5 backdrop-blur-xl shadow-[0_14px_34px_-12px_rgba(14,40,22,.38)]">
        @foreach ($bottomNavLinks as $link)
            <a href="{{ route($link['route']) }}" @if($link['active']) aria-current="page" @endif
               class="flex min-w-0 flex-1 flex-col items-center gap-0.5 rounded-2xl px-2 py-1.5 text-[11px] leading-tight font-semibold transition {{ $link['active'] ? 'text-accent-700' : 'text-ink/55 active:text-ink' }}">
                <span class="grid h-7 w-12 place-items-center rounded-full transition {{ $link['active'] ? 'bg-accent-100' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $tabIcons[$link['route']] ?? $tabIcons['home'] }}"/></svg>
                </span>
                <span class="truncate">{{ $link['label'] }}</span>
            </a>
        @endforeach
    </div>
</nav>
