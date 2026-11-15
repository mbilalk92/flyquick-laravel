@php $cards = $data['offer_cards'] ?? [
    ['category'=>'Family and community travel','title'=>'Current flight ideas for Pakistan','body'=>'Ask our team to compare current routes, baggage conditions and family travel options.','image'=>'/assets/images/destinations/pakistan.webp','link'=>'/flights/','label'=>'Ask for current options →'],
    ['category'=>'Flights and stays','title'=>'Build a Bali escape around your dates','body'=>'Combine current flight and accommodation choices in a tailored holiday itinerary.','image'=>'/assets/images/destinations/bali.webp','link'=>'/holiday-packages/','label'=>'Plan a Bali holiday →'],
    ['category'=>'Religious travel','title'=>'Discuss private and group Umrah','body'=>'Enquire about current journey structures, accommodation preferences and inclusions.','image'=>'/assets/images/destinations/umrah.webp','link'=>'/umrah/','label'=>'Explore Umrah →'],
]; @endphp
<section class="section offers-section">
    <div class="site-shell">
        <div class="section-heading split-heading">
            <div>
                <p class="eyebrow">Featured travel ideas</p>
                <h2>Start with an idea.<br>Confirm the current details.</h2>
            </div>
            <p>Offers, fares and package inclusions change. These ideas are enquiry starting points; Fly Quick will confirm current availability and conditions before booking.</p>
        </div>
        <div class="offer-grid">
            @foreach($cards as $card)
            <article class="offer-card">
                <div class="offer-image"><img src="{{ $card['image'] }}" alt="{{ $card['title'] }}"></div>
                <div class="offer-copy">
                    <p>{{ $card['category'] }}</p>
                    <h3>{{ $card['title'] }}</h3>
                    <span>{{ $card['body'] }}</span>
                    <a href="{{ $card['link'] }}">{{ $card['label'] }}</a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
