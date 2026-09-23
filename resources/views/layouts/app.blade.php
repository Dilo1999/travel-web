<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('travel.brand.name').' — '.config('travel.brand.tagline'))</title>
    <meta name="description" content="@yield('description', 'Inbound tours across every province of Sri Lanka, plus outbound holidays worldwide — planned and run by the people who answer your messages.')">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative flex min-h-screen flex-col overflow-x-hidden bg-canvas text-ink antialiased">

    <div class="pointer-events-none fixed inset-0 z-0" style="background:radial-gradient(60% 50% at 82% 4%,rgba(47,158,65,.14),transparent 70%),radial-gradient(52% 44% at 6% 32%,rgba(27,117,188,.10),transparent 72%)"></div>

    @include('partials.header')

    <main class="relative z-10 flex-1">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.whatsapp-widget')

</body>
</html>
