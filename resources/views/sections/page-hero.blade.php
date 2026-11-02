@php
    $heroImage = $data['image_url'] ?? null;
    $eyebrow   = $data['eyebrow']   ?? '';
    $heading   = $data['heading']   ?? '';
    $lead      = $data['lead']      ?? '';
    $showCta   = $data['show_cta']  ?? true;
@endphp
<section class="page-hero {{ $heroImage ? 'page-hero-image' : 'page-hero-simple' }}">
    @if($heroImage)
        <img class="page-hero-background" src="{{ $heroImage }}" alt="{{ $data['image_alt'] ?? '' }}">
    @endif
    <div class="page-hero-shade"></div>
    <div class="site-shell page-hero-content" id="main-content">
        @if($eyebrow)<p class="eyebrow eyebrow-light">{{ $eyebrow }}</p>@endif
        <h1>{{ $heading }}</h1>
        @if($lead)<p class="page-hero-lead">{{ $lead }}</p>@endif
        @if($showCta)
        <div class="hero-actions">
            <a class="button button-bright" href="/#search">Start your search →</a>
            <a class="button button-ghost" href="{{ config('site.whatsapp') }}" target="_blank" rel="noopener">Ask our team</a>
        </div>
        <div class="hero-proof">
            <span>✓ IATA accredited agent</span>
            <span>⌖ Australian owned</span>
            <span>◷ Extended hours</span>
        </div>
        @endif
    </div>
</section>
