@php $destinations = $data['destinations'] ?? [
    ['name'=>'Pakistan','desc'=>'Flights and family travel','image'=>'/assets/images/destinations/pakistan.webp','link'=>'/location/pakistan/'],
    ['name'=>'Bali','desc'=>'Beach stays and island escapes','image'=>'/assets/images/destinations/bali.webp','link'=>'/holiday-packages/'],
    ['name'=>'Umrah','desc'=>'Private and group journeys','image'=>'/assets/images/destinations/umrah.webp','link'=>'/religious-tours/'],
    ['name'=>'Australia','desc'=>'City breaks and outbound travel','image'=>'/assets/images/destinations/australia.webp','link'=>'/location/australia/'],
    ['name'=>'Canada','desc'=>'Cities, nature and family visits','image'=>'/assets/images/destinations/canada.webp','link'=>'/location/canada/'],
    ['name'=>'India','desc'=>'Culture, family and connections','image'=>'/assets/images/destinations/india.webp','link'=>'/location/india/'],
    ['name'=>'Nepal','desc'=>'Family travel and mountain escapes','image'=>'/assets/images/destinations/nepal.webp','link'=>'/location/nepal/'],
    ['name'=>'Saudi Arabia','desc'=>'Umrah, Hajj and stopover travel','image'=>'/assets/images/destinations/saudi-arabia.webp','link'=>'/location/saudi-arabia/'],
]; @endphp
<section class="section alt">
    <div class="site-shell">
        <div class="split-heading">
            <div>
                <p class="eyebrow">Popular destinations</p>
                <h2>Journeys worth looking forward to.</h2>
            </div>
            <p>Browse popular destinations or speak with our team for personalised advice on routes, fares and travel conditions.</p>
        </div>
        <div class="destination-list-grid">
            @foreach($destinations as $d)
            <article class="destination-list-card">
                <div><img src="{{ $d['image'] }}" alt="{{ $d['name'] }}"></div>
                <p>{{ $d['name'] }}</p>
                <h2>{{ $d['name'] }}</h2>
                <span>{{ $d['desc'] }}</span>
                <a href="{{ $d['link'] }}">Explore {{ $d['name'] }} →</a>
            </article>
            @endforeach
        </div>
    </div>
</section>
