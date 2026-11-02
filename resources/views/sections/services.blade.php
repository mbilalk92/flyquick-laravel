@php $cards = $data['cards'] ?? [
    ['icon'=>'✈','index'=>'01','title'=>'Flights without the guesswork','body'=>'Compare domestic and international options, then get human help with routing, baggage and fare conditions.','link'=>'/flights/','label'=>'Search flights →'],
    ['icon'=>'▥','index'=>'02','title'=>'Hotels that fit your trip','body'=>'Find the right stay for a quick stopover, family holiday, group journey or longer escape.','link'=>'/hotels/','label'=>'Find a stay →'],
    ['icon'=>'▣','index'=>'03','title'=>'Holidays built around you','body'=>'Bring flights, accommodation and the details that matter together in one well planned itinerary.','link'=>'/holiday-packages/','label'=>'Plan a holiday →'],
    ['icon'=>'◇','index'=>'04','title'=>'Umrah with thoughtful support','body'=>'Ask about private and group options with assistance across flights, stays and your complete journey.','link'=>'/umrah/','label'=>'Explore Umrah →'],
]; @endphp
<section class="section services-section" id="services">
    <div class="site-shell">
        <div class="section-heading split-heading">
            <div>
                <p class="eyebrow">Travel, made more personal</p>
                <h2>Everything you need.<br>One helpful team.</h2>
            </div>
            <p>Book independently when it suits you, with experienced travel specialists close by for complex itineraries, changes and personal advice.</p>
        </div>
        <div class="service-grid">
            @foreach($cards as $i => $card)
            <article class="service-card {{ $i === 0 ? 'featured' : '' }}">
                <div class="service-icon">{{ $card['icon'] }}</div>
                <p class="card-index">{{ $card['index'] }}</p>
                <h3>{{ $card['title'] }}</h3>
                <p>{{ $card['body'] }}</p>
                <a href="{{ $card['link'] }}">{{ $card['label'] }}</a>
            </article>
            @endforeach
        </div>
    </div>
</section>
