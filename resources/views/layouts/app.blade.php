<!doctype html>
<html lang="en-AU">
<head>
    @php
        $ogTitle = trim(View::hasSection('og_title') ? (string) View::getSection('og_title') : (string) View::getSection('meta_title')) ?: config('site.name', 'Fly Quick');
        $ogDescription = trim(View::hasSection('og_description') ? (string) View::getSection('og_description') : (string) View::getSection('meta_description'));
        $ogUrl = config('site.url') . (View::hasSection('canonical') ? View::getSection('canonical') : request()->path());
        $ogImage = View::hasSection('og_image') ? View::getSection('og_image') : rtrim(config('site.url'), '/') . '/assets/images/og-default.jpg';
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('meta_title', config('site.name', 'Fly Quick'))</title>
    <meta name="description" content="@yield('meta_description', '')">
    @if(View::hasSection('canonical'))
    <link rel="canonical" href="{{ config('site.url') }}@yield('canonical')">
    @endif

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_AU">
    <meta property="og:site_name" content="{{ config('site.name', 'Fly Quick') }}">
    <meta property="og:title" content="{!! $ogTitle !!}">
    <meta property="og:description" content="{!! $ogDescription !!}">
    <meta property="og:url" content="{{ $ogUrl }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{!! $ogTitle !!}">
    <meta name="twitter:description" content="{!! $ogDescription !!}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    {{-- Favicons --}}
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16x16.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/images/favicon-192x192.png">

    @if(config('analytics.google_site_verification'))
    <meta name="google-site-verification" content="{{ config('analytics.google_site_verification') }}">
    @endif

    @if(config('analytics.gtm_id'))
    {{-- Google Tag Manager --}}
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{{ config('analytics.gtm_id') }}');</script>
    @endif

    @if(config('analytics.ga4_id'))
    {{-- Google tag (gtag.js) --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('analytics.ga4_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ config('analytics.ga4_id') }}');
    </script>
    @endif

    @if(config('analytics.meta_pixel_id'))
    {{-- Meta Pixel --}}
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{ config('analytics.meta_pixel_id') }}');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id={{ config('analytics.meta_pixel_id') }}&ev=PageView&noscript=1"
    /></noscript>
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="/assets/css/style.css?v={{ file_exists(public_path('assets/css/style.css')) ? filemtime(public_path('assets/css/style.css')) : '1' }}">
    @stack('head')
</head>
<body>
    @if(config('analytics.gtm_id'))
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('analytics.gtm_id') }}"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif
    @include('components.header')
    <main @unless(View::hasSection('no_main_id')) id="main-content" @endunless>
        @yield('content')
    </main>
    @include('components.footer')
    @include('components.sabre-scripts')
    @stack('scripts')
</body>
</html>
