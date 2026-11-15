@php
    $eyebrow = $data['eyebrow'] ?? 'Choose the journey that suits you';
    $heading = $data['heading'] ?? 'Private, group and heritage travel.';
    $intro   = $data['intro'] ?? 'Package dates, inclusions and pricing change. Every journey is confirmed against current availability and supplier conditions before booking.';
@endphp
@php $journeys = $data['journeys'] ?? [
    ['name'=>'Private Umrah','desc'=>'A flexible journey arranged around your dates, preferred room type and travel needs.','href'=>'/religious-tours/private-umrah/','image'=>'/assets/images/religious/private-umrah.webp'],
    ['name'=>'Group Umrah','desc'=>'Travel with a coordinated group itinerary and support across flights, stays and transfers.','href'=>'/religious-tours/group-umrah/','image'=>'/assets/images/religious/group-umrah.webp'],
    ['name'=>'Private Hajj','desc'=>'Discuss tailored Hajj planning, subject to approved programs and availability.','href'=>'/religious-tours/private-hajj/','image'=>'/assets/images/religious/private-umrah.webp'],
    ['name'=>'Group Hajj','desc'=>'Register your interest in future group Hajj programs.','href'=>'/religious-tours/group-hajj/','image'=>'/assets/images/religious/group-hajj.webp'],
    ['name'=>'Ziarat journeys','desc'=>'Ask about organised visits to significant religious and historical destinations.','href'=>'/religious-tours/group-ziarat-iran/','image'=>'/assets/images/religious/group-ziyarat.webp'],
    ['name'=>'Islamic group tours','desc'=>'Explore history, culture and heritage through carefully planned group travel.','href'=>'/religious-tours/islamic-group-tour-spain/','image'=>'/assets/images/destinations/saudi-arabia.webp'],
]; @endphp
<section class="section journey-section">
    <div class="site-shell">
        <div class="section-heading split-heading">
            <div>
                <p class="eyebrow">{{ $eyebrow }}</p>
                <h2>{{ $heading }}</h2>
            </div>
            <p>{{ $intro }}</p>
        </div>
        <div class="journey-grid">
            @foreach($journeys as $j)
            <article class="journey-card">
                <a class="journey-image" href="{{ $j['href'] }}">
                    <img src="{{ $j['image'] }}" alt="{{ $j['name'] }}">
                </a>
                <div>
                    <h3>{{ $j['name'] }}</h3>
                    <p>{{ $j['desc'] }}</p>
                    <a href="{{ $j['href'] }}">Learn more →</a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
