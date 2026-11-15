@php $items = $data['faq_items'] ?? [
    ['q'=>'Can Fly Quick help with complex itineraries?','a'=>'Yes. Our team can help compare routes, fare conditions, baggage and practical details.'],
    ['q'=>'Can I enquire about Umrah travel?','a'=>'Yes. Ask about current private and group options and written inclusions.'],
    ['q'=>'What payment options are available?','a'=>'Available methods depend on the booking and provider conditions.'],
]; @endphp
<section class="section faq-section">
    <div class="site-shell faq-layout">
        <div class="faq-heading">
            <p class="eyebrow">Good to know</p>
            <h2>{{ $data['heading'] ?? 'Your travel questions, answered.' }}</h2>
            <p>Can't find what you need? Our team is available across seven days a week.</p>
            <a class="quiet-link dark" href="{{ config('site.whatsapp') }}">Ask us on WhatsApp →</a>
        </div>
        <div>
            @foreach($items as $item)
            <div class="faq">
                <button type="button" aria-expanded="false">{{ $item['q'] }}</button>
                <div hidden>{{ $item['a'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
