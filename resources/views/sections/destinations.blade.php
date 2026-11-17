@php
    $eyebrow   = $data['eyebrow'] ?? 'Popular ways to travel';
    $heading   = $data['heading'] ?? 'Journeys worth looking forward to.';
    $linkLabel = $data['link_label'] ?? 'Explore destinations →';
    $linkHref  = $data['link_href'] ?? '/locations/';
    $cards = $data['destination_cards'] ?? [
        ['tag'=>'Reconnect','title'=>'Pakistan','caption'=>'Flights and family travel','image'=>'/assets/images/destinations/pakistan.webp','alt'=>'Badshahi Mosque in Lahore','href'=>'/location/pakistan/'],
        ['tag'=>'Unwind','title'=>'Bali','caption'=>'Beach stays and escapes','image'=>'/assets/images/destinations/bali.webp','alt'=>'Bali coastline','href'=>'/holiday-packages/'],
        ['tag'=>'Reflect','title'=>'Umrah','caption'=>'Private and group journeys','image'=>'/assets/images/destinations/umrah.webp','alt'=>'Pilgrims at Masjid al-Haram','href'=>'/umrah/'],
    ];
    $fallbackHrefs = [
        'pakistan' => '/location/pakistan/',
        'bali'     => '/holiday-packages/',
        'umrah'    => '/umrah/',
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
            @php
                $href = $card['href'] ?? $fallbackHrefs[\Illuminate\Support\Str::slug($card['title'] ?? '')] ?? '#';
            @endphp
            <a class="destination-card {{ $i === 0 ? 'destination-wide' : '' }}" href="{{ $href }}">
                <img src="{{ $card['image'] }}" alt="{{ $card['alt'] ?? $card['title'] }}">
                <div class="destination-shade"></div>
                <div class="destination-copy"><p>{{ $card['tag'] }}</p><h3>{{ $card['title'] }}</h3><span>{{ $card['caption'] }}</span></div>
            </a>
            @endforeach
        </div>
    </div>
</section>
