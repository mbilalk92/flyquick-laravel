<?php

return [
    // GA4 measurement ID, e.g. G-XXXXXXXXXX (carried over from the old WordPress site)
    'ga4_id' => env('GA4_MEASUREMENT_ID'),

    // Google Tag Manager container ID, e.g. GTM-XXXXXXX (not used on the old site — none configured)
    'gtm_id' => env('GTM_CONTAINER_ID'),

    // Meta (Facebook) Pixel ID (carried over from the old WordPress site)
    'meta_pixel_id' => env('META_PIXEL_ID'),

    // Google Search Console HTML tag verification code (the <meta> content value only, not the whole tag)
    'google_site_verification' => env('GOOGLE_SITE_VERIFICATION'),
];
