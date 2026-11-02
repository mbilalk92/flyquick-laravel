@php
    $features = $data['features'] ?? [];
@endphp
<section class="section alt">
    <div class="site-shell">
        <div class="split-heading">
            <div>
                <p class="eyebrow">Travel to {{ $data['name'] ?? '' }}</p>
                <h2>{{ $data['intro_heading'] ?? '' }}</h2>
            </div>
            <p>{{ $data['intro'] ?? '' }}</p>
        </div>
        @if($features)
        <div class="feature-grid">
            @foreach($features as $f)
            <article class="feature-card">
                <span>{{ $f['icon'] ?? '✓' }}</span>
                <h3>{{ $f['title'] }}</h3>
                <p>{{ $f['body'] }}</p>
            </article>
            @endforeach
        </div>
        @endif
    </div>
</section>
