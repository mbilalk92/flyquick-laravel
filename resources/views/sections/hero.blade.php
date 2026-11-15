@php
    $eyebrow    = $data['eyebrow'] ?? 'Australian travel agency · Serving travellers since 2021';
    $heading1   = $data['heading_line1'] ?? 'Your next journey,';
    $heading2   = $data['heading_line2'] ?? 'handled with care.';
    $lead       = $data['lead'] ?? 'Search flights, stays and holidays, or speak with a real travel expert when your plans need a human touch.';
    $ctaLabel   = $data['cta_label'] ?? 'Start your search →';
    $ctaHref    = $data['cta_href'] ?? '#search';
    $phoneLabel = $data['phone_label'] ?? '☎ Talk to our team';
    $proof1     = $data['proof1'] ?? '✓ IATA accredited agent';
    $proof2     = $data['proof2'] ?? '◷ Open extended hours';
    $image      = $data['image_url'] ?? '/assets/images/hero-flight.webp';
    $imageAlt   = $data['image_alt'] ?? 'Aircraft wing above the clouds at sunrise';
@endphp
<section class="hero" id="top">
    <img class="hero-image" src="{{ $image }}" alt="{{ $imageAlt }}">
    <div class="hero-overlay"></div>
    <div class="site-shell hero-content" id="main-content">
        <div class="hero-copy">
            <p class="eyebrow eyebrow-light">{{ $eyebrow }}</p>
            <h1>{{ $heading1 }}<br><span>{{ $heading2 }}</span></h1>
            <p class="hero-lead">{{ $lead }}</p>
            <div class="hero-actions">
                <a class="button button-bright" href="{{ $ctaHref }}">{{ $ctaLabel }}</a>
                <a class="button button-ghost" href="{{ config('site.phone_href') }}">{{ $phoneLabel }}</a>
            </div>
            <div class="hero-proof">
                <span>{{ $proof1 }}</span>
                <span>{{ $proof2 }}</span>
            </div>
        </div>
    </div>
</section>
