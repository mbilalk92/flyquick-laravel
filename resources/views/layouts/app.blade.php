<!doctype html>
<html lang="en-AU">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('meta_title', config('site.name', 'Fly Quick'))</title>
    <meta name="description" content="@yield('meta_description', '')">
    @if(View::hasSection('canonical'))
    <link rel="canonical" href="{{ config('site.url') }}@yield('canonical')">
    @endif
    <link rel="stylesheet" href="/assets/css/style.css">
    @stack('head')
</head>
<body>
    @include('components.header')
    <main @unless(View::hasSection('no_main_id')) id="main-content" @endunless>
        @yield('content')
    </main>
    @include('components.footer')
    @include('components.sabre-scripts')
    @stack('scripts')
</body>
</html>
