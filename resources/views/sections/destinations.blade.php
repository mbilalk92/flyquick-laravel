@php
    $eyebrow   = $data['eyebrow'] ?? 'Popular ways to travel';
    $heading   = $data['heading'] ?? 'Journeys worth looking forward to.';
    $linkLabel = $data['link_label'] ?? 'Explore destinations →';
    $linkHref  = $data['link_href'] ?? '/locations/';
    $cards = $data['destination_cards'] ?? [
        ['tag'=>'Reconnect','title'=>'Pakistan','caption'=>'Flights and family travel','image'=>'/assets/images/destinations/pakistan.webp','alt'=>'Badshahi Mosque in Lahore'],
        ['tag'=>'Unwind','title'=>'Bali','caption'=>'Beach stays and escapes','image'=>'/assets/images/destinations/bali.webp','alt'=>'Bali coastline'],
        ['tag'=>'Reflect','title'=>'Umrah','caption'=>'Private and group journeys','image'=>'/assets/images/destinations/umrah.webp','alt'=>'Pilgrims at Masjid al-Haram'],
    ];
@endphp
<section class="section destination-section">
    <div class="site-shell">
        <div class="section-heading destination-heading">
            <div>
                <p class="eyebrow eyebrow-light">{{ $eyebrow }}</p>
                <h2>{{ $heading }}</h2>
            </div>
            <a class="quiet-link" href="{{ $linkHref }}">{{ $linkLabel }}</a>
        </div>
        <div class="destination-grid">
            @foreach($cards as $i => $card)
            <article class="destination-card {{ $i === 0 ? 'destination-wide' : '' }}">
                <img src="{{ $card['image'] }}" alt="{{ $card['alt'] ?? $card['title'] }}">
                <div class="destination-shade"></div>
                <div class="destination-copy"><p>{{ $card['tag'] }}</p><h3>{{ $card['title'] }}</h3><span>{{ $card['caption'] }}</span></div>
            </article>
            @endforeach
        </div>
    </div>
</section>
