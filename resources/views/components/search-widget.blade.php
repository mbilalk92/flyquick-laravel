<section class="search-card" aria-label="Travel search">
    <div class="search-tabs" role="tablist" aria-label="Search type">
        <button type="button" role="tab" aria-selected="true" class="search-tab active" data-sabre="AIR">✈ Flights</button>
    </div>
    <div class="search-form">
        <div class="search-form-heading">
            <div>
                {{-- <p class="search-kicker">Sabre powered booking</p> --}}
                <h2 id="sabre-tab-heading">Where would you like to fly?</h2>
            </div>
        </div>
        <iframe
            id="sabre-widget-frame"
            src="/widget/"
            scrolling="no"
            title="Flight and hotel search"
            allow="payment"
            sandbox="allow-scripts allow-forms allow-same-origin allow-popups"
            style="border:0;width:100%;display:block;min-height:300px;"></iframe>
        <div class="search-footnote">
            {{-- <p>Live availability and fares via Sabre GDS.</p> --}}
            <a href="{{ config('site.whatsapp') }}" target="_blank" rel="noopener">Prefer a tailored quote? Message us</a>
        </div>
    </div>
</section>
