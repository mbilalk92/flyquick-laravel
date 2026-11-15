@php
    $eyebrow = $data['eyebrow'] ?? 'The Fly Quick difference';
    $heading = $data['heading'] ?? 'Travel plans rarely fit a template.';
    $intro   = $data['intro'] ?? 'Online convenience is useful. So is knowing a real person can help when a connection is tight, a fare condition is unclear or plans change.';
    $statNumber = $data['stat_number'] ?? '7';
    $statLabel  = $data['stat_label'] ?? 'days a week|support';
    [$statLine1, $statLine2] = array_pad(explode('|', $statLabel, 2), 2, '');
    $note1 = $data['note1'] ?? 'Real people';
    $note2 = $data['note2'] ?? 'Extended hours';
    $note3 = $data['note3'] ?? 'Travel expertise';
    $items = $data['checklist'] ?? [
        'Advice shaped around your journey, not a generic script',
        'Support with booking changes, cancellations and refund requests',
        'Long opening hours aligned with Australian travellers',
        'Proudly Australian owned and serving customers since 2021',
    ];
@endphp
<section class="section support-section">
    <div class="site-shell support-layout">
        <div class="support-visual">
            <div class="support-orbit orbit-one"></div>
            <div class="support-orbit orbit-two"></div>
            <div class="support-core"><span>{{ $statNumber }}</span>
                <p>{{ $statLine1 }}<br>{{ $statLine2 }}</p>
            </div>
            <div class="support-note note-one">{{ $note1 }}</div>
            <div class="support-note note-two">{{ $note2 }}</div>
            <div class="support-note note-three">{{ $note3 }}</div>
        </div>
        <div class="support-copy">
            <p class="eyebrow">{{ $eyebrow }}</p>
            <h2>{{ $heading }}</h2>
            <p class="support-intro">{{ $intro }}</p>
            <ul class="check-list">
                @foreach($items as $item)
                <li><span>✓</span>{{ $item }}</li>
                @endforeach
            </ul>
            <div class="contact-pair">
                <a class="button button-dark" href="{{ config('site.phone_href') }}">{{ config('site.phone') }}</a>
                <a class="quiet-link dark" href="mailto:{{ config('site.email') }}">Email our team →</a>
            </div>
        </div>
    </div>
</section>
