<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedHome();
        $this->seedServicePage('flights', 'Flights | Fly Quick', 'Flights that fit the whole journey.', 'Domestic and international flights',
            'Search for a straightforward fare or ask our team to help with complex routes, baggage, family travel and fare conditions.',
            '/assets/images/hero-flight.webp', 'Aircraft wing above the clouds at sunrise',
            [
                ['✈', 'Domestic and international', 'Explore airline and routing options for travel within Australia and across the world.'],
                ['◇', 'Complex itineraries', 'Get help with multi-city, open-jaw, group and family journeys.'],
                ['✓', 'Clear fare conditions', 'Understand baggage, changes, cancellations and refund rules before booking.'],
                ['◷', 'After-booking support', 'Contact our team for eligible changes, reissues and refund requests.'],
            ]
        );
        $this->seedServicePage('hotels', 'Hotels | Fly Quick', 'A better stay starts with the right details.', 'Hotels and accommodation',
            'Find accommodation for stopovers, family holidays, work trips and longer stays, with human support when the options need a closer look.',
            '/assets/images/destinations/bali.webp', 'Coastal resort destination in Bali',
            [
                ['▥', 'Every kind of stay', 'Compare practical hotels, resorts, apartments and premium accommodation.'],
                ['◇', 'Family and group options', 'Ask about room configurations and group arrangements that suit your travellers.'],
                ['✓', 'Flexible choices', 'We can help identify refundable and changeable options where available.'],
                ['◷', 'Part of a complete trip', 'Combine your stay with flights and other travel arrangements.'],
            ]
        );
        $this->seedServicePage('holiday-packages', 'Holiday Packages | Fly Quick', 'A holiday planned around you.', 'Tailored holiday packages',
            'Bring flights, stays and the details that matter together in a clear itinerary for couples, families and groups.',
            '/assets/images/destinations/australia.webp', 'Australian harbour and city destination',
            [
                ['▣', 'One coordinated itinerary', 'Keep key trip arrangements together and easier to understand.'],
                ['◇', 'Destination advice', 'Discuss timing, stopovers and destination combinations with our team.'],
                ['✓', 'Family and group travel', 'Plan rooming, passenger needs and practical travel details together.'],
                ['◷', 'Flexible ways to pay', 'Ask about regular and eligible interest-free payment facilities.'],
            ]
        );
        $this->seedServicePage('umrah', 'Umrah Travel | Fly Quick', 'Your Umrah journey, handled with care.', 'Private and group Umrah',
            'Discuss flights, accommodation, transfers and itinerary options with a team that understands the importance of every part of your journey.',
            '/assets/images/destinations/umrah.webp', 'Pilgrims at Masjid al-Haram in Makkah',
            [
                ['◇', 'Private Umrah', 'Plan your journey around your preferred dates, room type and travel needs.'],
                ['▣', 'Group Umrah', 'Travel with a coordinated group, supported across flights, stays and transfers.'],
                ['✈', 'Flight assistance', 'Compare routes and conditions for Australia–Saudi Arabia travel.'],
                ['◷', 'Complete support', 'Our team assists with enquiries, bookings and changes across the journey.'],
            ]
        );
        $this->seedReligiousTours();
        $this->seedLocations();
        $this->seedAbout();
        $this->seedContact();
        $this->seedFaqs();
        $this->seedPaymentOptions();
        $this->seedCorporate();
        $this->seedPolicyPages();
    }

    private function seedHome(): void
    {
        $page = Page::firstOrCreate(['slug' => '/'], [
            'title'            => 'Home',
            'template'         => 'home',
            'meta_title'       => 'Fly Quick | Flights, Hotels, Packages & Umrah',
            'meta_description' => 'Search flights, hotels and holiday packages with personal support from Fly Quick, an Australian travel agency serving travellers since 2021.',
            'is_published'     => true,
        ]);

        $page->pageSections()->delete();
        $sections = [
            ['hero', []],
            ['search', []],
            ['trust-row', []],
            ['services', []],
            ['destinations', []],
            ['offers', []],
            ['support', []],
            ['payment', []],
            ['reviews', []],
            ['blog-preview', []],
            ['faq', ['heading' => 'Your travel questions, answered.', 'items' => [
                ['q' => 'Can Fly Quick help with complex itineraries?', 'a' => 'Yes. Our team can help compare routes, fare conditions, baggage and practical details.'],
                ['q' => 'Can I enquire about Umrah travel?', 'a' => 'Yes. Ask about current private and group options and written inclusions.'],
                ['q' => 'What payment options are available?', 'a' => 'Available methods depend on the booking and provider conditions.'],
            ]]],
        ];
        foreach ($sections as $i => [$type, $data]) {
            PageSection::create(['page_id' => $page->id, 'section_type' => $type, 'data' => $data ?: null, 'sort_order' => $i, 'is_active' => true]);
        }
    }

    private function seedServicePage(string $slug, string $metaTitle, string $heading, string $eyebrow, string $lead, string $heroImage, string $heroAlt, array $features): void
    {
        $title = $heading;
        $page  = Page::firstOrCreate(['slug' => $slug], [
            'title'            => $title,
            'template'         => 'default',
            'meta_title'       => $metaTitle,
            'meta_description' => $lead,
            'is_published'     => true,
        ]);

        $page->pageSections()->delete();
        $featureItems = array_map(fn($f) => ['icon' => $f[0], 'title' => $f[1], 'body' => $f[2]], $features);

        $sections = [
            ['page-hero', ['heading' => $heading, 'eyebrow' => $eyebrow, 'lead' => $lead, 'image_url' => $heroImage, 'image_alt' => $heroAlt, 'show_cta' => true]],
            ['breadcrumbs', ['crumbs' => [['label' => $title, 'url' => null]]]],
            ['features', ['heading' => 'Plan online. Get human help when needed.', 'items' => $featureItems]],
            ['inner-search', []],
            ['process', []],
        ];
        foreach ($sections as $i => [$type, $data]) {
            PageSection::create(['page_id' => $page->id, 'section_type' => $type, 'data' => $data ?: null, 'sort_order' => $i, 'is_active' => true]);
        }
    }

    private function seedReligiousTours(): void
    {
        $page = Page::firstOrCreate(['slug' => 'religious-tours'], [
            'title'            => 'Religious Journeys',
            'template'         => 'default',
            'meta_title'       => 'Religious Travel | Fly Quick',
            'meta_description' => 'Explore private and group options for Umrah, Hajj, Ziarat and Islamic tours with Fly Quick.',
            'is_published'     => true,
        ]);
        $page->pageSections()->delete();
        $sections = [
            ['page-hero', ['heading' => 'Religious journeys with thoughtful support.', 'eyebrow' => 'Umrah, Hajj, Ziarat and Islamic tours', 'lead' => 'Explore private and group options, with assistance across flights, accommodation, transfers and practical travel arrangements.', 'image_url' => '/assets/images/religious/group-umrah.webp', 'image_alt' => 'Travellers undertaking an Umrah journey', 'show_cta' => true]],
            ['breadcrumbs', ['crumbs' => [['label' => 'Religious Journeys', 'url' => null]]]],
            ['journey-grid', []],
            ['inner-search', []],
        ];
        foreach ($sections as $i => [$type, $data]) {
            PageSection::create(['page_id' => $page->id, 'section_type' => $type, 'data' => $data ?: null, 'sort_order' => $i, 'is_active' => true]);
        }

        // Individual religious tour pages
        $tours = [
            ['religious-tours/private-umrah', 'Private Umrah', 'Private Umrah, arranged around your needs.', 'Flexible religious travel', 'Choose dates, room preferences and a journey structure that fits your family or travelling party.', '/assets/images/religious/private-umrah.webp', 'Private Umrah travel'],
            ['religious-tours/group-umrah',   'Group Umrah',   'Share a supported group Umrah journey.', 'Coordinated group travel', 'Register your interest in organised departures with coordinated flights, stays and group arrangements.', '/assets/images/religious/group-umrah.webp', 'Group Umrah travel'],
            ['religious-tours/private-hajj',  'Private Hajj',  'Discuss a tailored Hajj journey.', 'Private Hajj enquiries', 'Ask our team about approved program availability, travel arrangements and current requirements.', '/assets/images/religious/private-umrah.webp', 'Religious travel to Makkah'],
            ['religious-tours/group-hajj',    'Group Hajj',    'Register your interest in group Hajj.', 'Group Hajj enquiries', 'Receive information about future group programs, subject to approved operators, allocations and availability.', '/assets/images/religious/group-hajj.webp', 'Group Hajj travel'],
            ['religious-tours/group-ziarat-iran',         'Ziarat Journeys', 'Ziarat journeys with a clear itinerary.', 'Group Ziarat enquiries', 'Ask about organised visits to important religious and historical destinations, with practical travel support.', '/assets/images/religious/group-ziyarat.webp', 'Ziarat destination and mosque architecture'],
            ['religious-tours/islamic-group-tour-spain',  'Islamic Group Tour Spain', 'Explore Islamic heritage in Spain.', 'Islamic history and group travel', 'Register your interest in a future guided itinerary exploring the history, architecture and culture of Al-Andalus.', '/assets/images/destinations/saudi-arabia.webp', 'Historic Islamic architecture'],
        ];

        foreach ($tours as [$slug, $title, $heading, $eyebrow, $desc, $image, $imageAlt]) {
            $tp = Page::firstOrCreate(['slug' => $slug], [
                'title'            => $title,
                'template'         => 'default',
                'meta_title'       => $title . ' | Fly Quick',
                'meta_description' => $desc,
                'is_published'     => true,
            ]);
            $tp->pageSections()->delete();
            $tourSections = [
                ['page-hero', ['heading' => $heading, 'eyebrow' => $eyebrow, 'lead' => $desc, 'image_url' => $image, 'image_alt' => $imageAlt, 'show_cta' => true]],
                ['breadcrumbs', ['crumbs' => [['label' => 'Religious Journeys', 'url' => '/religious-tours/'], ['label' => $title, 'url' => null]]]],
                ['features', ['heading' => 'What to expect', 'items' => [
                    ['icon' => '✓', 'title' => 'Tailored journey support', 'body' => 'Our team helps with flights, accommodation and all practical arrangements.'],
                    ['icon' => '◷', 'title' => 'Seven-day availability', 'body' => 'Reach our team across extended hours for enquiries and support.'],
                    ['icon' => '✈', 'title' => 'Flight assistance', 'body' => 'Compare current routes and conditions for Australia–Saudi Arabia travel.'],
                    ['icon' => '▣', 'title' => 'Written inclusions', 'body' => 'All journey details confirmed in writing before you book.'],
                ]]],
                ['inner-search', []],
            ];
            foreach ($tourSections as $i => [$type, $data]) {
                PageSection::create(['page_id' => $tp->id, 'section_type' => $type, 'data' => $data ?: null, 'sort_order' => $i, 'is_active' => true]);
            }
        }
    }

    private function seedLocations(): void
    {
        // Locations index
        $page = Page::firstOrCreate(['slug' => 'locations'], [
            'title'            => 'Destinations',
            'template'         => 'default',
            'meta_title'       => 'Destinations | Fly Quick',
            'meta_description' => 'Explore popular destinations and ask Fly Quick for current travel options.',
            'is_published'     => true,
        ]);
        $page->pageSections()->delete();
        foreach ([
            ['page-hero', ['heading' => 'Where will your journey take you?', 'eyebrow' => 'Explore', 'lead' => 'Start with inspiration, then ask our team to confirm current routes, stays and conditions.', 'image_url' => '/assets/images/destinations/canada.webp', 'image_alt' => 'Canadian mountain landscape', 'show_cta' => false]],
            ['breadcrumbs', ['crumbs' => [['label' => 'Destinations', 'url' => null]]]],
            ['destinations-list', []],
        ] as $i => [$type, $data]) {
            PageSection::create(['page_id' => $page->id, 'section_type' => $type, 'data' => $data ?: null, 'sort_order' => $i, 'is_active' => true]);
        }

        // Individual location pages
        $locations = [
            [
                'slug' => 'location/pakistan', 'name' => 'Pakistan', 'tagline' => 'Friendly People, Stunning Locations',
                'intro_heading' => 'Family travel and community connections.',
                'intro' => 'From the ancient bazaars of Lahore to the mountain landscapes of the north, Pakistan offers some of the most rewarding travel experiences available from Australia. Fly Quick specialises in helping Australian families and community travellers find current routes, compare fare conditions and navigate baggage for longer stays.',
                'image' => '/assets/images/destinations/pakistan.webp', 'image_alt' => 'Badshahi Mosque in Lahore, Pakistan',
                'meta_desc' => 'Flights from Australia to Pakistan — compare current routes to Lahore, Karachi and Islamabad with Fly Quick.',
                'features' => [
                    ['✈', 'Direct and connecting routes', 'Find routes via Dubai, Doha, Abu Dhabi and Kuala Lumpur to Lahore, Karachi and Islamabad.'],
                    ['▤', 'Generous baggage options', 'Many Pakistan routes include 30 kg+ checked baggage, important for family visits and long stays.'],
                    ['◷', 'Flexible travel dates', 'Ask about open-jaw itineraries and extended stays suited to family reunions and community visits.'],
                    ['◇', 'Group and family fares', 'Fly Quick can compare group pricing and seat availability across multiple passengers travelling together.'],
                ],
                'packages' => [
                    ['route' => 'Melbourne to Lahore', 'type' => 'Return flight · Family travel', 'desc' => 'A popular route for Australian Pakistani families. Fares have previously started from around $1,210 return with 30 kg baggage. Ask our team for current availability and conditions.', 'image' => '/assets/images/destinations/pakistan.webp'],
                ],
                'faqs' => [
                    ['Do I need a visa to visit Pakistan?', 'Australian citizens generally require a visa. Check the Pakistan High Commission website and allow sufficient processing time. Our team can advise on current requirements.'],
                    ['What baggage allowance do Pakistan routes include?', 'Many carriers offer 30 kg or more on Australia–Pakistan routes. Allowances vary by airline and fare class — ask us to confirm when comparing options.'],
                    ['Can Fly Quick help with group travel to Pakistan?', 'Yes. We assist families and community groups with coordinating seats, baggage and itineraries across multiple travellers.'],
                    ['What is the best time to travel to Pakistan?', 'October to March generally offers the most comfortable temperatures across most cities. Summer months can be very hot in low-lying areas.'],
                ],
            ],
            [
                'slug' => 'location/india', 'name' => 'India', 'tagline' => 'Where Diversity Thrives',
                'intro_heading' => 'Culture, family and connections.',
                'intro' => 'India offers a vast range of travel experiences, from major cities to coastal retreats and heritage sites. Fly Quick helps Australian travellers find current routes to Delhi, Mumbai, Chennai and beyond, with advice on connections, baggage and conditions for family and community visits.',
                'image' => '/assets/images/destinations/india.webp', 'image_alt' => 'Vibrant street scene in India',
                'meta_desc' => 'Flights from Australia to India — routes to Delhi, Mumbai and Chennai with Fly Quick.',
                'features' => [
                    ['✈', 'Multiple gateways', 'Routes to Delhi, Mumbai, Chennai, Hyderabad and other major cities.'],
                    ['▤', 'Baggage options', 'Ask about baggage allowances for long-haul India routes.'],
                    ['◷', 'Flexible dates', 'Open-jaw and multi-city itineraries available for extended family visits.'],
                    ['◇', 'Group travel', 'Coordinate seats and fares for family groups travelling together.'],
                ],
                'packages' => [
                    ['route' => 'Melbourne to Delhi', 'type' => 'Return flight · Family and cultural travel', 'desc' => 'Fares have previously started from around $1,500 return. Ask our team for current routes, connections and conditions.', 'image' => '/assets/images/destinations/india.webp'],
                ],
                'faqs' => [
                    ['Do Australians need a visa for India?', 'Yes. Australian passport holders require a visa for India. An e-Visa is available for eligible travellers. Check current requirements before booking.'],
                    ['What are the best routes from Australia to India?', 'Common connections include via Singapore, Dubai, Doha and Kuala Lumpur. Our team can compare current routing and timing options.'],
                ],
            ],
            [
                'slug' => 'location/nepal', 'name' => 'Nepal', 'tagline' => 'Unwind on Himalayan Slopes',
                'intro_heading' => 'Family travel and mountain escapes.',
                'intro' => 'Nepal combines remarkable mountain scenery with vibrant culture and a welcoming pace of life. Fly Quick helps Australian travellers plan flights to Kathmandu, with connections suited to family visits, trekking trips and cultural travel.',
                'image' => '/assets/images/destinations/nepal.webp', 'image_alt' => 'Himalayan mountain landscape in Nepal',
                'meta_desc' => 'Flights from Australia to Nepal — routes to Kathmandu with Fly Quick.',
                'features' => [
                    ['✈', 'Connecting routes', 'Common connections via Doha, Dubai, Singapore and Kuala Lumpur to Kathmandu.'],
                    ['▤', 'Baggage advice', 'Ask about baggage allowances for multi-leg Nepal itineraries.'],
                    ['◷', 'Seasonal travel', 'Plan around peak trekking seasons and family visit windows.'],
                    ['◇', 'Group coordination', 'Assistance with group itineraries and coordinated bookings.'],
                ],
                'packages' => [
                    ['route' => 'Melbourne to Kathmandu', 'type' => 'Return flight', 'desc' => 'Fares have previously started from around $1,257 return. Ask our team for current routes and conditions.', 'image' => '/assets/images/destinations/nepal.webp'],
                ],
                'faqs' => [
                    ['Do Australians need a visa for Nepal?', 'Yes. Australians can obtain a visa on arrival at Kathmandu airport or apply in advance. Check current requirements before travelling.'],
                    ['What is the best time to visit Nepal?', 'October–November and March–April are popular for clear mountain views and trekking. Ask our team about travel timing around your plans.'],
                ],
            ],
            [
                'slug' => 'location/canada', 'name' => 'Canada', 'tagline' => 'Experience Vast Wilderness',
                'intro_heading' => 'Cities, nature and family visits.',
                'intro' => 'Canada offers something for every kind of traveller, from cosmopolitan cities like Toronto and Vancouver to remarkable natural landscapes. Fly Quick assists Australian travellers with current routes, transit requirements and conditions for family visits and longer stays.',
                'image' => '/assets/images/destinations/canada.webp', 'image_alt' => 'Canadian mountain landscape with lake',
                'meta_desc' => 'Flights from Australia to Canada — routes to Toronto, Vancouver and beyond with Fly Quick.',
                'features' => [
                    ['✈', 'Multiple gateways', 'Routes to Toronto, Vancouver, Calgary and other Canadian cities.'],
                    ['▤', 'Transit requirements', 'Ask about eTA and transit visa requirements for Canada travel from Australia.'],
                    ['◷', 'Seasonal timing', 'Plan around winter and summer seasons depending on your activities.'],
                    ['◇', 'Family and group travel', 'Coordinate seats and baggage for families travelling together.'],
                ],
                'packages' => [
                    ['route' => 'Melbourne to Toronto', 'type' => 'Return flight', 'desc' => 'Fares have previously started from around $2,054 return. Ask our team for current routes, connections and conditions.', 'image' => '/assets/images/destinations/canada.webp'],
                ],
                'faqs' => [
                    ['Do Australians need a visa for Canada?', 'Australians require an Electronic Travel Authorisation (eTA) for air travel to Canada. This is different from a full visa and is applied for online.'],
                    ['What are the main routes from Australia to Canada?', 'Common connections include via Los Angeles, San Francisco, Tokyo and Hong Kong. Ask our team to compare current options.'],
                ],
            ],
            [
                'slug' => 'location/australia', 'name' => 'Australia', 'tagline' => 'Your travel starts here',
                'intro_heading' => 'Domestic and outbound travel from Australia.',
                'intro' => 'Fly Quick helps Australian travellers with both domestic flights and international departures. Whether you are planning a city break, a coastal holiday or a long-haul journey departing from an Australian gateway, our team can assist with current options.',
                'image' => '/assets/images/destinations/australia.webp', 'image_alt' => 'Australian cityscape',
                'meta_desc' => 'Domestic and outbound flights from Australia — search and enquire with Fly Quick.',
                'features' => [
                    ['✈', 'Domestic routes', 'Compare current fares between Australian cities.'],
                    ['▣', 'International departures', 'Plan long-haul travel departing from Melbourne, Sydney and other gateways.'],
                    ['◷', 'Flexible booking', 'Ask about fare conditions, changes and cancellation policies.'],
                    ['◇', 'Group and family travel', 'Assistance with coordinating seats for families and groups.'],
                ],
                'packages' => [
                    ['route' => 'Australia to London', 'type' => 'Return flight · International', 'desc' => 'Ask our team for current routes, connections and conditions for Australia–Europe travel.', 'image' => '/assets/images/destinations/australia.webp'],
                    ['route' => 'Australia to Tokyo', 'type' => 'Return flight · Asia Pacific', 'desc' => 'Popular destination for Australian travellers. Ask for current routes and fare conditions.', 'image' => '/assets/images/destinations/australia.webp'],
                    ['route' => 'Domestic Australia', 'type' => 'One-way or return', 'desc' => 'Compare current fares between Australian cities for short breaks and business travel.', 'image' => '/assets/images/destinations/australia.webp'],
                ],
                'faqs' => [
                    ['Can Fly Quick help with domestic Australian flights?', 'Yes. Our team can help compare current domestic fares, fare conditions and baggage options.'],
                    ['What international routes depart from Australia?', 'Major gateways include Melbourne, Sydney, Brisbane and Perth. Ask our team about current routes to your destination.'],
                ],
            ],
            [
                'slug' => 'location/saudi-arabia', 'name' => 'Saudi Arabia', 'tagline' => 'Umrah, Hajj and Cultural Travel',
                'intro_heading' => 'Religious and cultural journeys to Saudi Arabia.',
                'intro' => 'Saudi Arabia is the destination for millions of Muslim travellers each year, with Mecca and Medina at the heart of Umrah and Hajj pilgrimages. Fly Quick assists Australian travellers with flights, accommodation and complete journey arrangements for religious and cultural travel to Saudi Arabia.',
                'image' => '/assets/images/destinations/saudi-arabia.webp', 'image_alt' => 'Mecca and the Grand Mosque',
                'meta_desc' => 'Flights and travel to Saudi Arabia for Umrah, Hajj and cultural visits with Fly Quick.',
                'features' => [
                    ['◇', 'Umrah and Hajj support', 'Assistance with complete journey arrangements including flights, accommodation and transfers.'],
                    ['✈', 'Flight options', 'Compare routes from Melbourne to Jeddah and Riyadh via major connection points.'],
                    ['▤', 'Baggage advice', 'Ask about baggage allowances and restrictions relevant to religious travel.'],
                    ['◷', 'Year-round support', 'Our team assists with enquiries and arrangements for both Umrah and Hajj seasons.'],
                ],
                'packages' => [
                    ['route' => 'Melbourne to Jeddah', 'type' => 'Return flight · Umrah travel', 'desc' => 'A key route for Australian pilgrims. Ask our team for current availability, routes and conditions.', 'image' => '/assets/images/destinations/saudi-arabia.webp'],
                ],
                'faqs' => [
                    ['Do Australians need a visa for Saudi Arabia?', 'Yes. Australian citizens require a visa for Saudi Arabia. Umrah and Hajj travellers have specific visa requirements — our team can advise on current processes.'],
                    ['What is the difference between Umrah and Hajj?', 'Umrah is a voluntary pilgrimage that can be performed at any time of year. Hajj is the annual obligatory pilgrimage with specific dates in the Islamic calendar.'],
                    ['Can Fly Quick arrange the full Umrah package?', 'Yes. We can assist with flights, accommodation in Mecca and Medina, and transfers. Ask our team for current options and inclusions.'],
                ],
            ],
        ];

        foreach ($locations as $loc) {
            $lp = Page::firstOrCreate(['slug' => $loc['slug']], [
                'title'            => $loc['name'],
                'template'         => 'location',
                'meta_title'       => $loc['name'] . ' Flights & Travel | Fly Quick',
                'meta_description' => $loc['meta_desc'],
                'is_published'     => true,
            ]);
            $lp->pageSections()->delete();

            $faqItems = array_map(fn($f) => ['q' => $f[0], 'a' => $f[1]], $loc['faqs']);
            $featItems = array_map(fn($f) => ['icon' => $f[0], 'title' => $f[1], 'body' => $f[2]], $loc['features']);

            $pkgItems = array_map(fn($p) => [
                'route' => $p['route'], 'type' => $p['type'], 'desc' => $p['desc'], 'image' => $p['image'],
            ], $loc['packages']);

            $sections = [
                ['page-hero', ['heading' => $loc['name'], 'eyebrow' => 'Destination', 'lead' => $loc['tagline'], 'image_url' => $loc['image'], 'image_alt' => $loc['image_alt'], 'show_cta' => false]],
                ['breadcrumbs', ['crumbs' => [['label' => 'Destinations', 'url' => '/locations/'], ['label' => $loc['name'], 'url' => null]]]],
                ['location-intro', ['name' => $loc['name'], 'intro_heading' => $loc['intro_heading'], 'intro' => $loc['intro'], 'features' => $featItems]],
                ['packages', ['packages' => $pkgItems]],
                ['faq', ['heading' => 'Your ' . $loc['name'] . ' travel questions, answered.', 'items' => $faqItems]],
            ];
            foreach ($sections as $i => [$type, $data]) {
                PageSection::create(['page_id' => $lp->id, 'section_type' => $type, 'data' => $data ?: null, 'sort_order' => $i, 'is_active' => true]);
            }
        }
    }

    private function seedAbout(): void
    {
        $page = Page::firstOrCreate(['slug' => 'about'], [
            'title'            => 'About Fly Quick',
            'template'         => 'default',
            'meta_title'       => 'About Fly Quick',
            'meta_description' => 'Learn about Fly Quick, an Australian travel agency combining online convenience with personal service.',
            'is_published'     => true,
        ]);
        $page->pageSections()->delete();
        foreach ([
            ['page-hero', ['heading' => 'Travel support with a human touch.', 'eyebrow' => 'Proudly Australian', 'lead' => 'Helping Australian travellers plan flights, stays, holidays and meaningful journeys since 2021.', 'image_url' => '/assets/images/hero-flight.webp', 'image_alt' => 'Aircraft wing above the clouds', 'show_cta' => false]],
            ['breadcrumbs', ['crumbs' => [['label' => 'About Fly Quick', 'url' => null]]]],
            ['about-story', []],
        ] as $i => [$type, $data]) {
            PageSection::create(['page_id' => $page->id, 'section_type' => $type, 'data' => $data ?: null, 'sort_order' => $i, 'is_active' => true]);
        }
    }

    private function seedContact(): void
    {
        $page = Page::firstOrCreate(['slug' => 'contact'], [
            'title'            => 'Contact Fly Quick',
            'template'         => 'default',
            'meta_title'       => 'Contact Fly Quick',
            'meta_description' => 'Contact Fly Quick for help with flights, hotels, holidays and religious travel.',
            'is_published'     => true,
        ]);
        $page->pageSections()->delete();
        foreach ([
            ['page-hero', ['heading' => 'Real help, across extended hours.', 'eyebrow' => 'Contact us', 'lead' => 'Tell us what you are planning and our travel team will respond.', 'show_cta' => false]],
            ['breadcrumbs', ['crumbs' => [['label' => 'Contact', 'url' => null]]]],
            ['contact', []],
        ] as $i => [$type, $data]) {
            PageSection::create(['page_id' => $page->id, 'section_type' => $type, 'data' => $data ?: null, 'sort_order' => $i, 'is_active' => true]);
        }
    }

    private function seedFaqs(): void
    {
        $page = Page::firstOrCreate(['slug' => 'faqs'], [
            'title'            => 'FAQs',
            'template'         => 'default',
            'meta_title'       => 'Frequently Asked Questions | Fly Quick',
            'meta_description' => 'Answers to common questions about Fly Quick travel services, bookings and payments.',
            'is_published'     => true,
        ]);
        $page->pageSections()->delete();
        foreach ([
            ['page-hero', ['heading' => 'Your travel questions, answered.', 'eyebrow' => 'Good to know', 'show_cta' => false]],
            ['breadcrumbs', ['crumbs' => [['label' => 'FAQs', 'url' => null]]]],
            ['faq', ['heading' => 'Common questions', 'items' => [
                ['q' => 'Can Fly Quick help with complex itineraries?', 'a' => 'Yes. Our team can help compare routes, fare conditions, baggage and practical details.'],
                ['q' => 'Can I enquire about Umrah or Hajj travel?', 'a' => 'Yes. Contact us for current private and group options, availability and written inclusions.'],
                ['q' => 'What payment options are available?', 'a' => 'Payment availability varies by booking. Bank transfer, cards and eligible instalment facilities may be offered.'],
                ['q' => 'Can you help after I book?', 'a' => 'Our team can assist with change, cancellation and refund requests subject to airline and supplier conditions.'],
                ['q' => 'When is Fly Quick open?', 'a' => 'Mon–Sat 9am–11pm · Sun 11am–7pm, Melbourne time.'],
            ]]],
        ] as $i => [$type, $data]) {
            PageSection::create(['page_id' => $page->id, 'section_type' => $type, 'data' => $data ?: null, 'sort_order' => $i, 'is_active' => true]);
        }
    }

    private function seedPaymentOptions(): void
    {
        $page = Page::firstOrCreate(['slug' => 'payment-options'], [
            'title'            => 'Payment Options',
            'template'         => 'default',
            'meta_title'       => 'Payment Options | Fly Quick',
            'meta_description' => 'Explore payment options available when booking with Fly Quick, including interest-free options.',
            'is_published'     => true,
        ]);
        $page->pageSections()->delete();
        foreach ([
            ['page-hero', ['heading' => 'Flexible ways to pay.', 'eyebrow' => 'Pay with clarity', 'lead' => 'Availability depends on the booking channel, amount, provider approval and product conditions.', 'show_cta' => false]],
            ['breadcrumbs', ['crumbs' => [['label' => 'Payment Options', 'url' => null]]]],
            ['payment', []],
        ] as $i => [$type, $data]) {
            PageSection::create(['page_id' => $page->id, 'section_type' => $type, 'data' => $data ?: null, 'sort_order' => $i, 'is_active' => true]);
        }
    }

    private function seedCorporate(): void
    {
        $page = Page::firstOrCreate(['slug' => 'corporate-travel-australia'], [
            'title'            => 'Corporate Travel',
            'template'         => 'default',
            'meta_title'       => 'Corporate Travel Australia | Fly Quick',
            'meta_description' => 'Corporate travel services for Australian businesses. Flights, accommodation and travel management with personal support.',
            'is_published'     => true,
        ]);
        $page->pageSections()->delete();
        foreach ([
            ['page-hero', ['heading' => 'Business travel, handled with care.', 'eyebrow' => 'Corporate travel Australia', 'lead' => 'Flights, accommodation and travel management for Australian businesses, with personal support from our team.', 'image_url' => '/assets/images/hero-flight.webp', 'image_alt' => 'Aircraft in flight', 'show_cta' => true]],
            ['breadcrumbs', ['crumbs' => [['label' => 'Corporate Travel', 'url' => null]]]],
            ['features', ['heading' => 'Supporting Australian business travellers', 'items' => [
                ['icon' => '✈', 'title' => 'Business class and premium options', 'body' => 'Ask about current fares and availability in business and premium economy cabins.'],
                ['icon' => '▥', 'title' => 'Accommodation', 'body' => 'Find suitable corporate stays close to business districts and venues.'],
                ['icon' => '◷', 'title' => 'Flexible booking', 'body' => 'Ask about fully flexible fare conditions suited to changing business schedules.'],
                ['icon' => '◇', 'title' => 'After-hours support', 'body' => 'Reach our team across extended hours for time-sensitive changes.'],
            ]]],
            ['process', []],
        ] as $i => [$type, $data]) {
            PageSection::create(['page_id' => $page->id, 'section_type' => $type, 'data' => $data ?: null, 'sort_order' => $i, 'is_active' => true]);
        }
    }

    private function seedPolicyPages(): void
    {
        $policies = [
            [
                'privacy-policy', 'Privacy Policy',
                'Important information about how Fly Quick handles personal information.',
                '<h2>Information we collect</h2><p>We may collect contact details and travel information that you provide when making an enquiry or booking.</p><h2>How information is used</h2><p>We use submitted information to respond to enquiries, arrange requested services, maintain records and meet legal obligations.</p><h2>Contact</h2><p>Privacy questions may be sent to support@flyquick.com.au.</p>',
            ],
            [
                'terms-and-conditions', 'Terms and Conditions',
                'Terms and conditions for use of Fly Quick services.',
                '<h2>Use of services</h2><p>By making an enquiry or booking through Fly Quick, you agree to these terms.</p><h2>Booking conditions</h2><p>All bookings are subject to airline and supplier conditions. Fly Quick acts as an agent and will communicate conditions in writing before confirmation.</p><h2>Contact</h2><p>Questions may be sent to support@flyquick.com.au.</p>',
            ],
            [
                'refund-policy', 'Refund Policy',
                'Information about refunds and cancellations for Fly Quick bookings.',
                '<h2>Refund eligibility</h2><p>Refund eligibility depends on the fare type, airline and supplier conditions that apply to your booking. Our team will advise on the specific conditions before you confirm.</p><h2>Requesting a refund</h2><p>Contact our team to initiate a refund or cancellation request. Processing times vary by airline and supplier.</p><h2>Contact</h2><p>Refund enquiries may be sent to support@flyquick.com.au.</p>',
            ],
            [
                'cookie-policy', 'Cookie Policy',
                'Information about how Fly Quick uses cookies on this website.',
                '<h2>What are cookies</h2><p>Cookies are small text files stored on your device when you visit a website. They help the site function and provide usage information.</p><h2>How we use cookies</h2><p>This website may use cookies for analytics and to improve your experience. No personal booking data is stored in cookies.</p><h2>Contact</h2><p>Cookie questions may be sent to support@flyquick.com.au.</p>',
            ],
        ];

        foreach ($policies as [$slug, $title, $summary, $content]) {
            $page = Page::firstOrCreate(['slug' => $slug], [
                'title'            => $title,
                'template'         => 'default',
                'meta_title'       => $title . ' | Fly Quick',
                'meta_description' => $summary,
                'is_published'     => true,
            ]);
            $page->pageSections()->delete();
            foreach ([
                ['page-hero', ['heading' => $title, 'eyebrow' => 'Fly Quick policies', 'lead' => $summary, 'show_cta' => false]],
                ['breadcrumbs', ['crumbs' => [['label' => $title, 'url' => null]]]],
                ['rich-text', ['content' => $content]],
            ] as $i => [$type, $data]) {
                PageSection::create(['page_id' => $page->id, 'section_type' => $type, 'data' => $data ?: null, 'sort_order' => $i, 'is_active' => true]);
            }
        }
    }
}
