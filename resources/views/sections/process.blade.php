@php
    $eyebrow = $data['eyebrow'] ?? 'A simple way forward';
    $heading = $data['heading'] ?? 'From first idea to confirmed journey.';
    $steps   = $data['steps'] ?? [
        ['number'=>'01','title'=>'Share your plans','body'=>'Tell us your dates, preferences and priorities.'],
        ['number'=>'02','title'=>'Compare options','body'=>'Review current availability, inclusions and conditions.'],
        ['number'=>'03','title'=>'Book with clarity','body'=>'Confirm after receiving the important details in writing.'],
    ];
@endphp
<section class="section process-section">
    <div class="site-shell">
        <p class="eyebrow">{{ $eyebrow }}</p>
        <h2 class="compact-heading">{{ $heading }}</h2>
        <div class="process-grid">
            @foreach($steps as $step)
            <article><span>{{ $step['number'] }}</span><h3>{{ $step['title'] }}</h3><p>{{ $step['body'] }}</p></article>
            @endforeach
        </div>
    </div>
</section>
