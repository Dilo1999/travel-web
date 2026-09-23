@php
    $isHome = request()->routeIs('home');
    // Pages that open with a full-width image hero — the header can start
    // transparent over it and turn solid glass once the page is scrolled.
    $heroRoutes = ['home', 'destinations', 'packages.index', 'packages.show', 'gallery', 'about', 'contact'];
    $hasHero = collect($heroRoutes)->contains(fn ($route) => request()->routeIs($route));
    $navLinks = [
        ['label' => 'Home', 'route' => 'home', 'active' => request()->routeIs('home')],
        ['label' => 'Destinations', 'route' => 'destinations', 'active' => request()->routeIs('destinations')],
        ['label' => 'Packages', 'route' => 'packages.index', 'active' => request()->routeIs('packages.*')],
        ['label' => 'Gallery', 'route' => 'gallery', 'active' => request()->routeIs('gallery*')],
        ['label' => 'About', 'route' => 'about', 'active' => request()->routeIs('about')],
        ['label' => 'Contact', 'route' => 'contact', 'active' => request()->routeIs('contact')],
    ];
@endphp

<header class="site-header sticky top-0 z-50">
    <div
        data-nav-bar
        @if($hasHero) data-transparent-hero @endif
        class="relative transition-colors duration-300 {{ $hasHero ? '' : 'header-bar text-ink' }}"
    >
        <div class="mx-auto flex h-20 max-w-[1400px] items-center gap-1 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="mr-auto flex items-center">
                <img data-nav-logo src="{{ asset('images/logo/nio-logo.png') }}" alt="{{ config('travel.brand.name') }}" class="h-16 w-auto transition-[filter] duration-300">
            </a>

            <nav class="hidden items-center gap-0.5 lg:flex">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="rounded-full px-3 py-2 text-[12.5px] font-semibold whitespace-nowrap transition hover:bg-white/20 {{ $link['active'] ? 'underline decoration-2 underline-offset-4' : '' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </nav>

            <a href="{{ route('contact') }}" class="btn btn-primary ml-4 hidden px-4 py-2.5 text-[12.5px] sm:inline-flex">
                Enquire
            </a>

            <button data-mobile-menu-toggle type="button" aria-expanded="false" aria-label="Open menu"
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
    <div class="flex min-h-screen flex-col px-6 pt-24 pb-10">
        <nav class="flex flex-col gap-1">
            @foreach ($navLinks as $link)
                <a data-mobile-menu-close href="{{ route($link['route']) }}"
                   class="rounded-2xl px-4 py-4 text-lg font-semibold {{ $link['active'] ? 'bg-accent-100 text-accent-800' : 'hover:bg-black/5' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>
        <a data-mobile-menu-close href="{{ route('contact') }}" class="btn btn-primary mt-6 justify-center py-4 text-sm">
            Enquire now
        </a>
    </div>
</div>
