@php
    $phone      = config('site.phone');
    $phoneHref  = config('site.phone_href');
    $whatsapp   = config('site.whatsapp');
    $hours      = config('site.hours');
@endphp
<a class="skip-link" href="#main-content">Skip to main content</a>
<div class="support-strip">
    <div class="site-shell support-strip-inner">
        <p><span class="status-dot"></span>Extended hours support, seven days a week</p>
        <div class="support-strip-links">
            <span>{{ $hours }}</span>
            <a href="{{ $phoneHref }}">☎ {{ $phone }}</a>
        </div>
    </div>
</div>
<header class="site-header">
    <div class="site-shell nav-shell">
        <a class="brand" href="/" aria-label="Fly Quick home">
            <img src="/assets/images/flyquick-logo.png" alt="Fly Quick" width="284" height="80">
        </a>
        <nav class="main-nav" id="main-nav" aria-label="Main navigation">
            <div class="nav-item"><a href="/flights/">Flights</a></div>
            <div class="nav-item"><a href="/hotels/">Hotels</a></div>
            <div class="nav-item"><a href="/holiday-packages/">Holiday packages</a></div>
            <div class="nav-item">
                <a href="/religious-tours/">Umrah <span class="nav-caret">⌄</span></a>
                <div class="nav-dropdown">
                    <a href="/religious-tours/">Religious travel overview</a>
                    <a href="/religious-tours/private-umrah/">Private Umrah</a>
                    <a href="/religious-tours/group-umrah/">Group Umrah</a>
                    <a href="/religious-tours/private-hajj/">Private Hajj</a>
                    <a href="/religious-tours/group-hajj/">Group Hajj</a>
                    <a href="/religious-tours/group-ziarat-iran/">Ziarat journeys</a>
                </div>
            </div>
            <div class="nav-item">
                <a href="/locations/">Destinations <span class="nav-caret">⌄</span></a>
                <div class="nav-dropdown">
                    <a href="/locations/">All destinations</a>
                    <a href="/location/pakistan/">Pakistan</a>
                    <a href="/location/india/">India</a>
                    <a href="/location/nepal/">Nepal</a>
                    <a href="/location/canada/">Canada</a>
                    <a href="/location/australia/">Australia</a>
                    <a href="/location/saudi-arabia/">Saudi Arabia</a>
                </div>
            </div>
            <div class="nav-item"><a href="/payment-options/">Payment options</a></div>
            <div class="nav-item">
                <a href="/about/">More <span class="nav-caret">⌄</span></a>
                <div class="nav-dropdown">
                    <a href="/about/">About Fly Quick</a>
                    <a href="/corporate-travel-australia/">Corporate travel</a>
                    <a href="/faqs/">FAQs</a>
                    <a href="/contact/">Contact us</a>
                </div>
            </div>
        </nav>
        <div class="nav-actions">
            <a class="text-action" href="{{ $whatsapp }}" target="_blank" rel="noopener">WhatsApp</a>
            <a class="button button-small" href="/#search">Get a quote</a>
        </div>
        <button class="menu-button" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="main-nav">
            <span>☰</span>
        </button>
    </div>
</header>
