@php
    $heading = $data['heading'] ?? 'Reach Fly Quick';
    $defaultTravelType = $data['default_travel_type'] ?? null;
    $anchorId = $data['anchor_id'] ?? null;
@endphp
<section class="section alt" @if($anchorId) id="{{ $anchorId }}" @endif>
    <div class="shell two-col">
        <aside>
            <h2>{{ $heading }}</h2>
            <p><strong>Call</strong><br><a href="{{ config('site.phone_href') }}">{{ config('site.phone') }}</a></p>
            <p><strong>Email</strong><br><a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></p>
            <p><strong>WhatsApp</strong><br><a href="{{ config('site.whatsapp') }}" target="_blank" rel="noopener">Message our team</a></p>
            <p><strong>Hours</strong><br>{{ config('site.hours') }}</p>
        </aside>
        @include('sections.contact-form')
    </div>
</section>
