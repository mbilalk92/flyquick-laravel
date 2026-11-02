@php $quote = $data['quote'] ?? 'I had an outstanding experience with Fly Quick for my recent vacation planning.';
$author = $data['author'] ?? 'Hafiz Ahmed · Fly Quick customer feedback'; @endphp
<section class="section review-section">
    <div class="site-shell review-layout">
        <div>
            <p class="eyebrow">Customer care that travels further</p>
            <h2>Service people remember.</h2>
            <div class="review-rating">★★★★★ <span>Fly Quick customer feedback</span></div>
        </div>
        <blockquote>
            <span class="quote-mark">"</span>
            <p>{{ $quote }}</p>
            <footer>{{ $author }}</footer>
        </blockquote>
    </div>
</section>
