@php $items = $data['items'] ?? []; @endphp
<section class="section intro-section">
    <div class="site-shell">
        <div class="section-heading split-heading">
            <div>
                <p class="eyebrow">Travel support that stays clear</p>
                <h2>{{ $data['heading'] ?? 'Plan online. Get human help when needed.' }}</h2>
            </div>
            <p>{{ $data['subheading'] ?? 'Use the search area as your starting point. If the journey is complex, our team can help you compare the practical details before you commit.' }}</p>
        </div>
        <div class="feature-grid">
            @foreach($items as $item)
            <article class="feature-card">
                <span>{{ $item['icon'] ?? '✓' }}</span>
                <h3>{{ $item['title'] }}</h3>
                <p>{{ $item['body'] }}</p>
            </article>
            @endforeach
        </div>
    </div>
</section>
