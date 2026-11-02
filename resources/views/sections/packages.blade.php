@php $packages = $data['packages'] ?? []; @endphp
@if($packages)
<section class="section offers-section">
    <div class="site-shell">
        <div class="section-heading split-heading">
            <div>
                <p class="eyebrow">Featured travel ideas</p>
                <h2>Start with an idea.<br>Confirm the current details.</h2>
            </div>
            <p>Fares, availability and conditions change. These are enquiry starting points — Fly Quick will confirm current options before you book.</p>
        </div>
        <div class="offer-grid">
            @foreach($packages as $p)
            <article class="offer-card">
                <div class="offer-image"><img src="{{ $p['image'] }}" alt="{{ $p['route'] }}"></div>
                <div class="offer-copy">
                    <p>{{ $p['type'] ?? 'Return flight' }}</p>
                    <h3>{{ $p['route'] }}</h3>
                    <span>{{ $p['desc'] }}</span>
                    <a href="/flights/">Ask for current options →</a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
