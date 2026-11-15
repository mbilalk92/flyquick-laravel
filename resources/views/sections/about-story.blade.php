@php
    $eyebrow    = $data['eyebrow'] ?? 'Our story';
    $heading    = $data['heading'] ?? 'Online convenience and personal service, together.';
    $paragraph1 = $data['paragraph1'] ?? 'Fly Quick was built around a simple belief: customers should be able to start online, then reach a real travel specialist when a route, fare condition or change needs more attention.';
    $paragraph2 = $data['paragraph2'] ?? 'Our team supports leisure, family, religious and business travel, with extended hours that reflect how Australians plan international journeys.';
    $cards      = $data['story_cards'] ?? [
        ['title'=>'Since 2021','body'=>'Serving Australian travellers.'],
        ['title'=>'7 days','body'=>'Extended weekly support.'],
        ['title'=>'Human advice','body'=>'Help when bookings need care.'],
    ];
@endphp
<section class="section alt">
    <div class="shell two-col">
        <div>
            <p class="eyebrow">{{ $eyebrow }}</p>
            <h2>{{ $heading }}</h2>
            <p>{{ $paragraph1 }}</p>
            <p>{{ $paragraph2 }}</p>
        </div>
        <div class="grid">
            @foreach($cards as $card)
            <article class="card"><h3>{{ $card['title'] }}</h3><p>{{ $card['body'] }}</p></article>
            @endforeach
        </div>
    </div>
</section>
