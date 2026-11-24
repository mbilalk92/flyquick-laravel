<?php

return [
    'url'        => env('SITE_URL',        'https://flyquick.com.au'),
    'phone'      => env('SITE_PHONE',      '+61 3 9017 1800'),
    'phone_href' => env('SITE_PHONE_HREF', 'tel:+61390171800'),
    'email'      => env('SITE_EMAIL',      'support@flyquick.com.au'),
    'whatsapp'   => env('SITE_WHATSAPP',   'https://wa.me/61390171800?text=Hi%20Fly%20Quick%2C%20I%27d%20like%20help%20planning%20a%20trip.'),
    'hours'      => env('SITE_HOURS',      'Mon–Sat 9am–11pm · Sun 11am–7pm, Melbourne time'),
    'blog_url'   => env('BLOG_URL',        'http://flyquick-static.test/blog'),

    // Raw script snippets, editable from Admin → Site Settings → Custom Scripts
    // (SEO verification tags, extra tracking pixels, etc). Overridden at runtime
    // from the settings table — see AppServiceProvider::boot(). Blank by default.
    'header_scripts' => env('SITE_HEADER_SCRIPTS', ''),
    'body_scripts'   => env('SITE_BODY_SCRIPTS', ''),
    'footer_scripts' => env('SITE_FOOTER_SCRIPTS', ''),

    // Social links, editable from Admin → Site Settings → Social Media.
    // Blank hides the icon in the footer — see components/footer.blade.php.
    'social' => [
        'facebook'  => '',
        'instagram' => '',
        'twitter'   => '',
        'linkedin'  => '',
        'youtube'   => '',
        'tiktok'    => '',
    ],
];
