@php
    $heading = $data['heading'] ?? 'Reach Fly Quick';
    $defaultTravelType = $data['default_travel_type'] ?? null;
    $anchorId = $data['anchor_id'] ?? null;

    $socialLinks = array_filter([
        'facebook'  => ['url' => config('site.social.facebook'),  'icon' => 'fa-facebook-f', 'label' => 'Facebook'],
        'instagram' => ['url' => config('site.social.instagram'), 'icon' => 'fa-instagram',  'label' => 'Instagram'],
        'twitter'   => ['url' => config('site.social.twitter'),   'icon' => 'fa-x-twitter',  'label' => 'Twitter / X'],
        'linkedin'  => ['url' => config('site.social.linkedin'),  'icon' => 'fa-linkedin-in','label' => 'LinkedIn'],
        'youtube'   => ['url' => config('site.social.youtube'),   'icon' => 'fa-youtube',    'label' => 'YouTube'],
        'tiktok'    => ['url' => config('site.social.tiktok'),    'icon' => 'fa-tiktok',     'label' => 'TikTok'],
    ], fn ($link) => filled($link['url']));
@endphp
<section class="section alt" @if($anchorId) id="{{ $anchorId }}" @endif>
    <div class="shell two-col">
        <aside class="contact-info">
            <h2>{{ $heading }}</h2>
            <p class="contact-info-lead">Prefer to talk it through? Our team replies fast across every channel below.</p>

            <div class="contact-info-card">
                <div class="contact-info-item">
                    <span class="contact-info-icon"><i class="fa-solid fa-phone" aria-hidden="true"></i></span>
                    <div>
                        <strong>Call</strong>
                        <a href="{{ config('site.phone_href') }}">{{ config('site.phone') }}</a>
                    </div>
                </div>
                <div class="contact-info-item">
                    <span class="contact-info-icon"><i class="fa-solid fa-envelope" aria-hidden="true"></i></span>
                    <div>
                        <strong>Email</strong>
                        <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a>
                    </div>
                </div>
                <div class="contact-info-item">
                    <span class="contact-info-icon"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></span>
                    <div>
                        <strong>WhatsApp</strong>
                        <a href="{{ config('site.whatsapp') }}" target="_blank" rel="noopener">Message our team</a>
                    </div>
                </div>
                <div class="contact-info-item">
                    <span class="contact-info-icon"><i class="fa-regular fa-clock" aria-hidden="true"></i></span>
                    <div>
                        <strong>Hours</strong>
                        <p>{{ config('site.hours') }}</p>
                    </div>
                </div>
            </div>

            @if($socialLinks)
            <div class="contact-social" aria-label="Follow Fly Quick on social media">
                <span>Follow us</span>
                @foreach($socialLinks as $social)
                <a href="{{ $social['url'] }}" target="_blank" rel="noopener" aria-label="{{ $social['label'] }}">
                    <i class="fa-brands {{ $social['icon'] }}" aria-hidden="true"></i>
                </a>
                @endforeach
            </div>
            @endif
        </aside>
        @include('sections.contact-form')
    </div>
</section>
