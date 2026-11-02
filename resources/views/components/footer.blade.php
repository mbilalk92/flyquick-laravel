@php
    $phone     = config('site.phone');
    $phoneHref = config('site.phone_href');
    $email     = config('site.email');
    $whatsapp  = config('site.whatsapp');
    $hours     = config('site.hours');
@endphp
<section class="closing-cta">
    <div class="site-shell closing-cta-inner">
        <div>
            <p class="eyebrow eyebrow-light">Search. Explore. Travel.</p>
            <h2>Where will you go next?</h2>
        </div>
        <div class="closing-actions">
            <a class="button button-bright" href="/#search">Search your trip</a>
            <a class="button button-ghost" href="{{ $whatsapp }}" target="_blank" rel="noopener">Message Fly Quick</a>
        </div>
    </div>
</section>
<footer class="footer">
    <div class="site-shell footer-grid">
        <div class="footer-brand">
            <img src="/assets/images/flyquick-logo.png" alt="Fly Quick" width="284" height="80">
            <p>Flights, stays and journeys made easier with personal support from an Australian travel agency.</p>
            <p class="legal-name">Fly Quick Pty Ltd · Australian owned · Serving travellers since 2021</p>
        </div>
        <div>
            <h3>Plan your trip</h3>
            <a href="/flights/">Flights</a>
            <a href="/hotels/">Hotels</a>
            <a href="/holiday-packages/">Holiday packages</a>
            <a href="/locations/">Destinations</a>
        </div>
        <div>
            <h3>Fly Quick</h3>
            <a href="/about/">About us</a>
            <a href="/corporate-travel-australia/">Corporate travel</a>
            <a href="/religious-tours/">Religious travel</a>
            <a href="/payment-options/">Payment options</a>
            <a href="/faqs/">FAQs</a>
        </div>
        <div class="footer-contact">
            <h3>Talk to us</h3>
            <a href="{{ $phoneHref }}">{{ $phone }}</a>
            <a href="mailto:{{ $email }}">{{ $email }}</a>
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener">WhatsApp</a>
            <p>{{ $hours }}<br><small>Face-to-face meetings by appointment only.</small></p>
        </div>
    </div>
    <div class="site-shell footer-bottom">
        <p>© {{ date('Y') }} Fly Quick Pty Ltd. All rights reserved.</p>
        <div>
            <a href="/privacy-policy/">Privacy policy</a>
            <a href="/terms-and-conditions/">Terms and conditions</a>
            <a href="/refund-policy/">Refund policy</a>
            <a href="/cookie-policy/">Cookie policy</a>
        </div>
    </div>
</footer>
<nav class="mobile-contact-bar" aria-label="Quick contact">
    <a href="{{ $phoneHref }}">Call</a>
    <a href="{{ $whatsapp }}">WhatsApp</a>
    <a href="/#search">Search</a>
</nav>
<script src="/assets/js/main.js" defer></script>
