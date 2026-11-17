@php
    $eyebrow     = $data['eyebrow'] ?? 'More flexibility at checkout';
    $heading     = $data['heading'] ?? 'Choose a way to pay that works for you.';
    $body        = $data['body'] ?? 'Pay using regular methods or explore eligible interest-free payment options when booking with Fly Quick.';
    $disclaimer  = $data['disclaimer'] ?? 'Eligibility, approval, limits, fees and provider terms and conditions apply.';
    $linkLabel   = $data['link_label'] ?? 'Compare payment options →';
    $linkHref    = $data['link_href'] ?? '/payment-options/';
    $panelLabel  = $data['panel_label'] ?? 'Available interest-free options may include';
    $logos       = $data['logos'] ?? [
        ['label' => 'humm90'],
        ['label' => 'Zip'],
    ];
    $acceptedLabel = $data['accepted_label'] ?? 'Also accepted';
    $acceptedText  = $data['accepted_text'] ?? 'Credit card · Bank transfer';
@endphp
<section class="payment-section">
    <div class="site-shell payment-layout">
        <div class="payment-copy">
            <p class="eyebrow">{{ $eyebrow }}</p>
            <h2>{{ $heading }}</h2>
            <p>{{ $body }}</p>
            <p class="payment-disclaimer">{{ $disclaimer }}</p>
            <a class="quiet-link dark" href="{{ $linkHref }}">{{ $linkLabel }}</a>
        </div>
        <div class="payment-panel">
            <p class="payment-panel-label">{{ $panelLabel }}</p>
            <div class="payment-logos">
                @foreach($logos as $logo)
                @php
                    $logoLabel = is_array($logo) ? ($logo['label'] ?? '') : $logo;
                    $logoImage = is_array($logo) ? ($logo['image'] ?? null) : null;
                    $logoIcon  = is_array($logo) ? ($logo['icon'] ?? null) : null;
                @endphp
                <div class="payment-logo">
                    @if($logoImage)
                        <img src="{{ $logoImage }}" alt="{{ $logoLabel }}">
                    @elseif($logoIcon)
                        <i class="{{ $logoIcon }}" aria-hidden="true"></i>
                        @if($logoLabel)<small>{{ $logoLabel }}</small>@endif
                    @else
                        {{ $logoLabel }}
                    @endif
                </div>
                @endforeach
            </div>
            <div class="regular-payments">
                <span>{{ $acceptedLabel }}</span>
                <p>{{ $acceptedText }}</p>
            </div>
        </div>
    </div>
</section>
