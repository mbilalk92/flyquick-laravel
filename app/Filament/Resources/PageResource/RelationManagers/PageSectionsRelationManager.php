<?php

namespace App\Filament\Resources\PageResource\RelationManagers;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PageSectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'pageSections';
    protected static ?string $title = 'Sections';

    /**
     * Curated Font Awesome Free classes offered in the icon dropdowns below.
     * Browse the full set at https://fontawesome.com/icons and use the
     * "Custom icon class" field if what you need isn't in this shortlist.
     */
    protected static function iconOptions(): array
    {
        return [
            'fa-solid fa-plane' => 'Plane',
            'fa-solid fa-plane-departure' => 'Plane departure',
            'fa-solid fa-hotel' => 'Hotel',
            'fa-solid fa-bed' => 'Bed',
            'fa-solid fa-suitcase-rolling' => 'Suitcase',
            'fa-solid fa-passport' => 'Passport',
            'fa-solid fa-globe' => 'Globe',
            'fa-solid fa-map-location-dot' => 'Map / location',
            'fa-solid fa-route' => 'Route',
            'fa-solid fa-clock' => 'Clock / hours',
            'fa-solid fa-calendar-check' => 'Calendar check',
            'fa-solid fa-circle-check' => 'Check circle',
            'fa-solid fa-shield-halved' => 'Shield',
            'fa-solid fa-headset' => 'Support / headset',
            'fa-solid fa-phone' => 'Phone',
            'fa-solid fa-envelope' => 'Email',
            'fa-solid fa-comments' => 'Chat',
            'fa-solid fa-credit-card' => 'Credit card',
            'fa-solid fa-money-bill-wave' => 'Money',
            'fa-solid fa-star' => 'Star',
            'fa-solid fa-award' => 'Award',
            'fa-solid fa-thumbs-up' => 'Thumbs up',
            'fa-solid fa-users' => 'Users / group',
            'fa-solid fa-user-check' => 'Verified user',
            'fa-solid fa-building' => 'Building',
            'fa-solid fa-briefcase' => 'Corporate travel',
            'fa-solid fa-kaaba' => 'Kaaba (Umrah)',
            'fa-solid fa-person-praying' => 'Praying',
            'fa-solid fa-sun' => 'Sun / holiday',
            'fa-solid fa-umbrella-beach' => 'Beach holiday',
            'fa-solid fa-mountain-sun' => 'Mountain / adventure',
            'fa-solid fa-ticket' => 'Ticket',
            'fa-solid fa-magnifying-glass' => 'Search',
            'fa-solid fa-gauge-high' => 'Speed',
            'fa-solid fa-lock' => 'Secure',
            'fa-solid fa-circle-info' => 'Info',
            'fa-solid fa-flag' => 'Flag',
        ];
    }

    /**
     * Every per-section-type Section block below shares the same `data.*`
     * dot-paths across DIFFERENT section types (e.g. both "features" and
     * "trust-row" bind a Repeater to `data.items` with different item
     * shapes). ->visible() on the Section only hides it from view — by
     * default Filament still dehydrates (saves) every field's state
     * regardless of visibility, so saving ANY section silently ran every
     * other type's same-path fields through state too, each overwriting
     * the last and nesting mismatched array shapes under a synthetic
     * "item" key. Wrapping each Section's field list in this helper makes
     * every top-level field in it dehydrate only when its own section type
     * is the one actually selected, eliminating the collision.
     */
    protected static function dehydrateWhen(string $type, array $fields): array
    {
        $condition = fn (Get $get) => $get('section_type') === $type;

        foreach ($fields as $field) {
            $field->dehydrated($condition);
        }

        return $fields;
    }

    /**
     * ->dehydrated() on the Section blocks above does NOT stop Livewire's
     * form hydration from cross-polluting same-path fields (e.g. both
     * "features" and "trust-row" bind a Repeater to `data.items`): every
     * alternate section-type schema still exists in the same component
     * tree regardless of which one is visible, so they all read/write the
     * same underlying array during a single edit, nesting mismatched
     * shapes under a synthetic "item" key. This is the actual safety net:
     * run right before every create/update, it (1) unwraps any such
     * accidental nesting back to the real leaf value, then (2) strips the
     * result down to only the keys that belong to the record's own
     * section_type, so whatever garbage other types' hidden fields wrote
     * never reaches the database.
     */
    protected static function cleanSectionData(array $formData): array
    {
        if (! isset($formData['data']) || ! is_array($formData['data'])) {
            return $formData;
        }

        $allowedKeysByType = [
            'page-hero' => ['heading', 'eyebrow', 'lead', 'image_media_id', 'image_url', 'image_alt', 'show_cta', 'cta_label', 'cta_href'],
            'breadcrumbs' => ['crumbs'],
            'features' => ['heading', 'feature_items'],
            'faq' => ['heading', 'faq_items'],
            'rich-text' => ['content'],
            'packages' => ['packages'],
            'location-intro' => ['name', 'intro_heading', 'intro', 'features'],
            'offers' => ['offer_cards'],
            'hero' => ['eyebrow', 'heading_line1', 'heading_line2', 'lead', 'cta_label', 'cta_href', 'phone_label', 'proof1', 'proof2', 'image_media_id', 'image_url', 'image_alt'],
            'trust-row' => ['items'],
            'services' => ['eyebrow', 'heading', 'intro', 'cards'],
            'destinations' => ['eyebrow', 'heading', 'link_label', 'link_href', 'destination_cards'],
            'destinations-list' => ['eyebrow', 'heading', 'intro', 'destinations'],
            'journey-grid' => ['eyebrow', 'heading', 'intro', 'journeys'],
            'payment' => ['eyebrow', 'heading', 'body', 'disclaimer', 'link_label', 'link_href', 'panel_label', 'logos', 'accepted_label', 'accepted_text'],
            'reviews' => ['eyebrow', 'heading', 'quote', 'author'],
            'process' => ['eyebrow', 'heading', 'steps'],
            'about-story' => ['eyebrow', 'heading', 'paragraph1', 'paragraph2', 'story_cards'],
            'blog-preview' => ['eyebrow', 'heading', 'link_label'],
            'support' => ['eyebrow', 'heading', 'intro', 'stat_number', 'stat_label', 'note1', 'note2', 'note3', 'checklist'],
            'contact' => ['heading', 'default_travel_type', 'anchor_id'],
        ];

        $unwrap = function ($value) use (&$unwrap) {
            while (is_array($value) && array_key_exists('item', $value) && is_array($value['item'])) {
                $value = $value['item'];
            }

            if (is_array($value)) {
                foreach ($value as $key => $nested) {
                    $value[$key] = $unwrap($nested);
                }
            }

            return $value;
        };

        $clean = $unwrap($formData['data']);

        $allowed = $allowedKeysByType[$formData['section_type'] ?? ''] ?? [];
        $clean = array_intersect_key($clean, array_flip($allowed));

        // Drop null/''/[] values so an untouched or blanked-out field falls
        // back to the Blade template's built-in default (`$data['x'] ?? ...`)
        // instead of persisting an explicit empty value that defeats it.
        $formData['data'] = array_filter($clean, fn ($value) => $value !== null && $value !== '' && $value !== []);

        return $formData;
    }

    /**
     * Plain `icon` text field (unchanged storage format: a Font Awesome
     * class string) with a picker button that fills it from a curated list.
     * Deliberately NOT a second Repeater-item field: an extra live/
     * non-dehydrated sibling field inside a Repeater item schema is what
     * was corrupting Livewire's snapshot on add/remove-item actions.
     */
    protected static function iconField(): Forms\Components\TextInput
    {
        return Forms\Components\TextInput::make('icon')
            ->label('Icon')
            ->placeholder('fa-solid fa-plane')
            ->helperText('Font Awesome class, e.g. fa-solid fa-plane. Browse more at fontawesome.com/icons.')
            ->suffixAction(
                Forms\Components\Actions\Action::make('pickIcon')
                    ->icon('heroicon-m-swatch')
                    ->tooltip('Choose from common icons')
                    ->modalHeading('Choose an icon')
                    ->modalSubmitActionLabel('Use this icon')
                    ->form([
                        Forms\Components\Select::make('value')
                            ->label('Icon')
                            ->options(static::iconOptions())
                            ->searchable()
                            ->native(false)
                            ->required(),
                    ])
                    ->action(function (array $data, Forms\Set $set) {
                        $set('icon', $data['value']);
                    }),
            );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('section_type')
                    ->label('Section type')
                    ->options([
                        'Page structure' => [
                            'page-hero'   => 'Page Hero (heading + image)',
                            'breadcrumbs' => 'Breadcrumb trail',
                        ],
                        'Content blocks' => [
                            'features'    => 'Feature grid',
                            'faq'         => 'FAQ accordion',
                            'rich-text'   => 'Rich text',
                            'about-story' => 'About story',
                        ],
                        'Travel tools' => [
                            'inner-search'   => 'Search bar (inner pages, no editable content)',
                            'search'         => 'Search widget (home, no editable content)',
                            'packages'       => 'Package cards',
                            'location-intro' => 'Location intro + features',
                            'journey-grid'   => 'Religious journeys grid',
                        ],
                        'Discovery' => [
                            'services'          => 'Services grid',
                            'destinations'      => 'Destinations grid',
                            'destinations-list' => 'Destinations list',
                            'offers'            => 'Offer cards',
                        ],
                        'Trust & social' => [
                            'trust-row' => 'Trust row',
                            'support'   => 'The Fly Quick difference (support)',
                            'reviews'   => 'Reviews',
                            'payment'   => 'Payment options',
                        ],
                        'Support' => [
                            'process' => 'How it works',
                            'contact' => 'Contact (heading + form)',
                        ],
                        'Blog' => [
                            'blog-preview' => 'Blog preview',
                        ],
                        'Home hero' => [
                            'hero' => 'Hero banner (home only)',
                        ],
                    ])
                    ->required()
                    ->live()
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->label('Active')
                    ->inline(false),

                Forms\Components\TextInput::make('sort_order')
                    ->label('Sort order (lower = first)')
                    ->numeric()
                    ->default(0),

                // ── Sections notice (truly nothing to configure) ────────
                Forms\Components\Placeholder::make('_static_note')
                    ->label('')
                    ->content('This section just displays the search widget — there is no text content to edit here.')
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => in_array($get('section_type'), [
                        'search', 'inner-search',
                    ])),

                // ── page-hero ───────────────────────────────────────────
                Forms\Components\Section::make('Page hero content')
                    ->schema(static::dehydrateWhen('page-hero', [
                        Forms\Components\TextInput::make('data.heading')
                            ->label('Heading (H1)')
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('data.eyebrow')
                            ->label('Eyebrow label')
                            ->columnSpan(2),
                        Forms\Components\Textarea::make('data.lead')
                            ->label('Lead paragraph')
                            ->rows(2)
                            ->columnSpan(2),
                        CuratorPicker::make('data.image_media_id')
                            ->label('Hero image')
                            ->buttonLabel('Pick / upload image')
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $media = is_array($state) ? reset($state) : null;
                                if ($media) {
                                    $set('data.image_url', $media['url'] ?? null);
                                    $set('data.image_alt', $media['alt'] ?? $media['name'] ?? '');
                                }
                            }),
                        Forms\Components\TextInput::make('data.image_url')
                            ->label('Image URL (auto-filled from picker, or enter manually)')
                            ->placeholder('/assets/images/destinations/bali.webp'),
                        Forms\Components\TextInput::make('data.image_alt')
                            ->label('Image alt text'),
                        Forms\Components\Toggle::make('data.show_cta')
                            ->label('Show "Get in touch" button')
                            ->default(false)
                            ->inline(false),
                        Forms\Components\TextInput::make('data.cta_label')
                            ->label('Button label (defaults to "Start your search →")'),
                        Forms\Components\TextInput::make('data.cta_href')
                            ->label('Button URL (defaults to the home search, /#search)'),
                    ]))
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'page-hero'),

                // ── breadcrumbs ─────────────────────────────────────────
                Forms\Components\Section::make('Breadcrumb trail')
                    ->schema(static::dehydrateWhen('breadcrumbs', [
                        Forms\Components\Repeater::make('data.crumbs')
                            ->label('Items between "Home" and the current page')
                            ->helperText('Leave URL blank on the last item (current page).')
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->label('Label')
                                    ->required(),
                                Forms\Components\TextInput::make('url')
                                    ->label('URL (blank = current page)')
                                    ->placeholder('/locations/'),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]))
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'breadcrumbs'),

                // ── features ────────────────────────────────────────────
                Forms\Components\Section::make('Feature grid content')
                    ->schema(static::dehydrateWhen('features', [
                        Forms\Components\TextInput::make('data.heading')
                            ->label('Section heading')
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('data.feature_items')
                            ->label('Feature items')
                            ->schema([
                                static::iconField(),
                                Forms\Components\TextInput::make('title')
                                    ->label('Title'),
                                Forms\Components\Textarea::make('body')
                                    ->label('Body text')
                                    ->rows(2)
                                    ->columnSpan(2),
                            ])
                            ->columns(2)
                            ->defaultItems(4)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]))
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'features'),

                // ── faq ─────────────────────────────────────────────────
                Forms\Components\Section::make('FAQ content')
                    ->schema(static::dehydrateWhen('faq', [
                        Forms\Components\TextInput::make('data.heading')
                            ->label('Section heading')
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('data.faq_items')
                            ->label('FAQ items')
                            ->schema([
                                Forms\Components\TextInput::make('q')
                                    ->label('Question')
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('a')
                                    ->label('Answer')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->columns(1)
                            ->defaultItems(3)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]))
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'faq'),

                // ── rich-text ───────────────────────────────────────────
                Forms\Components\Section::make('Rich text content')
                    ->schema(static::dehydrateWhen('rich-text', [
                        Forms\Components\RichEditor::make('data.content')
                            ->label('Content')
                            ->toolbarButtons(['bold', 'italic', 'link', 'orderedList', 'bulletList', 'h2', 'h3'])
                            ->columnSpanFull(),
                    ]))
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'rich-text'),

                // ── packages ────────────────────────────────────────────
                Forms\Components\Section::make('Package cards')
                    ->schema(static::dehydrateWhen('packages', [
                        Forms\Components\Repeater::make('data.packages')
                            ->label('Package cards')
                            ->schema([
                                Forms\Components\TextInput::make('route')
                                    ->label('Route (e.g. Melbourne to Lahore)'),
                                Forms\Components\TextInput::make('type')
                                    ->label('Type tag'),
                                Forms\Components\Textarea::make('desc')
                                    ->label('Description')
                                    ->rows(2)
                                    ->columnSpan(2),
                                CuratorPicker::make('image_media_id')
                                    ->label('Image (pick / upload)')
                                    ->buttonLabel('Pick / upload image')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        $media = is_array($state) ? reset($state) : null;
                                        if ($media) { $set('image', $media['url'] ?? null); }
                                    }),
                                Forms\Components\TextInput::make('image')
                                    ->label('Image URL (auto-filled or manual)')
                                    ->placeholder('/assets/images/destinations/pakistan.webp')
                                    ->columnSpan(2),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]))
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'packages'),

                // ── location-intro ──────────────────────────────────────
                Forms\Components\Section::make('Location intro content')
                    ->schema(static::dehydrateWhen('location-intro', [
                        Forms\Components\TextInput::make('data.name')
                            ->label('Destination name'),
                        Forms\Components\TextInput::make('data.intro_heading')
                            ->label('Intro heading'),
                        Forms\Components\Textarea::make('data.intro')
                            ->label('Intro paragraph')
                            ->rows(4)
                            ->columnSpan(2),
                        Forms\Components\Repeater::make('data.features')
                            ->label('Feature list')
                            ->schema([
                                static::iconField(),
                                Forms\Components\TextInput::make('title')->label('Title'),
                                Forms\Components\Textarea::make('body')->label('Body')->rows(2)->columnSpan(2),
                            ])
                            ->columns(2)
                            ->defaultItems(4)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]))
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'location-intro'),

                // ── offers ──────────────────────────────────────────────
                Forms\Components\Section::make('Offer cards')
                    ->schema(static::dehydrateWhen('offers', [
                        Forms\Components\Placeholder::make('_offers_hint')
                            ->label('')
                            ->content('Leave empty to use the default Pakistan / Bali / Umrah cards.')
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('data.offer_cards')
                            ->label('Custom offer cards')
                            ->schema([
                                Forms\Components\TextInput::make('category')->label('Category label'),
                                Forms\Components\TextInput::make('title')->label('Card title'),
                                Forms\Components\Textarea::make('body')->label('Body text')->rows(2)->columnSpan(2),
                                CuratorPicker::make('image_media_id')
                                    ->label('Image (pick / upload)')
                                    ->buttonLabel('Pick / upload image')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        $media = is_array($state) ? reset($state) : null;
                                        if ($media) { $set('image', $media['url'] ?? null); }
                                    }),
                                Forms\Components\TextInput::make('image')->label('Image URL (auto-filled or manual)')->columnSpan(2),
                                Forms\Components\TextInput::make('link')->label('Link URL'),
                                Forms\Components\TextInput::make('label')->label('Link label'),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]))
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'offers'),

                // ── hero (home only) ────────────────────────────────────
                Forms\Components\Section::make('Hero banner content')
                    ->schema(static::dehydrateWhen('hero', [
                        Forms\Components\TextInput::make('data.eyebrow')->label('Eyebrow label')->columnSpanFull(),
                        Forms\Components\TextInput::make('data.heading_line1')->label('Heading line 1'),
                        Forms\Components\TextInput::make('data.heading_line2')->label('Heading line 2 (highlighted)'),
                        Forms\Components\Textarea::make('data.lead')->label('Lead paragraph')->rows(2)->columnSpanFull(),
                        Forms\Components\TextInput::make('data.cta_label')->label('Primary button label'),
                        Forms\Components\TextInput::make('data.cta_href')->label('Primary button link'),
                        Forms\Components\TextInput::make('data.phone_label')->label('Phone button label'),
                        Forms\Components\TextInput::make('data.proof1')->label('Proof point 1'),
                        Forms\Components\TextInput::make('data.proof2')->label('Proof point 2'),
                        CuratorPicker::make('data.image_media_id')
                            ->label('Hero background image')
                            ->buttonLabel('Pick / upload image')
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $media = is_array($state) ? reset($state) : null;
                                if ($media) {
                                    $set('data.image_url', $media['url'] ?? null);
                                    $set('data.image_alt', $media['alt'] ?? $media['name'] ?? '');
                                }
                            }),
                        Forms\Components\TextInput::make('data.image_url')->label('Image URL (auto-filled or manual)'),
                        Forms\Components\TextInput::make('data.image_alt')->label('Image alt text'),
                    ]))
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'hero'),

                // ── trust-row ────────────────────────────────────────────
                Forms\Components\Section::make('Trust row items')
                    ->schema(static::dehydrateWhen('trust-row', [
                        Forms\Components\Repeater::make('data.items')
                            ->label('Items')
                            ->schema([
                                static::iconField(),
                                Forms\Components\TextInput::make('title')->label('Title'),
                                Forms\Components\TextInput::make('text')->label('Text'),
                            ])
                            ->columns(3)
                            ->defaultItems(4)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]))
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'trust-row'),

                // ── services ────────────────────────────────────────────
                Forms\Components\Section::make('Services grid content')
                    ->schema(static::dehydrateWhen('services', [
                        Forms\Components\TextInput::make('data.eyebrow')->label('Eyebrow label'),
                        Forms\Components\TextInput::make('data.heading')->label('Heading (use <br> for a line break)'),
                        Forms\Components\Textarea::make('data.intro')->label('Intro paragraph')->rows(2)->columnSpanFull(),
                        Forms\Components\Repeater::make('data.cards')
                            ->label('Service cards')
                            ->schema([
                                static::iconField(),
                                Forms\Components\TextInput::make('index')->label('Index (e.g. 01)'),
                                Forms\Components\TextInput::make('title')->label('Title')->columnSpan(2),
                                Forms\Components\Textarea::make('body')->label('Body')->rows(2)->columnSpan(2),
                                Forms\Components\TextInput::make('link')->label('Link URL'),
                                Forms\Components\TextInput::make('label')->label('Link label'),
                            ])
                            ->columns(2)
                            ->defaultItems(4)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]))
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'services'),

                // ── destinations (home grid) ────────────────────────────
                Forms\Components\Section::make('Destinations grid content')
                    ->schema(static::dehydrateWhen('destinations', [
                        Forms\Components\TextInput::make('data.eyebrow')->label('Eyebrow label'),
                        Forms\Components\TextInput::make('data.heading')->label('Heading'),
                        Forms\Components\TextInput::make('data.link_label')->label('Link label'),
                        Forms\Components\TextInput::make('data.link_href')->label('Link URL'),
                        Forms\Components\Repeater::make('data.destination_cards')
                            ->label('Destination cards')
                            ->schema([
                                Forms\Components\TextInput::make('tag')->label('Tag (e.g. Reconnect)'),
                                Forms\Components\TextInput::make('title')->label('Title'),
                                Forms\Components\TextInput::make('caption')->label('Caption')->columnSpan(2),
                                Forms\Components\TextInput::make('href')->label('Link URL (whole card is clickable)')->columnSpan(2),
                                CuratorPicker::make('image_media_id')
                                    ->label('Image (pick / upload)')
                                    ->buttonLabel('Pick / upload image')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        $media = is_array($state) ? reset($state) : null;
                                        if ($media) { $set('image', $media['url'] ?? null); }
                                    }),
                                Forms\Components\TextInput::make('image')->label('Image URL (auto-filled or manual)')->columnSpan(2),
                                Forms\Components\TextInput::make('alt')->label('Image alt text')->columnSpan(2),
                            ])
                            ->columns(2)
                            ->defaultItems(3)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]))
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'destinations'),

                // ── destinations-list ────────────────────────────────────
                Forms\Components\Section::make('Destinations list content')
                    ->schema(static::dehydrateWhen('destinations-list', [
                        Forms\Components\TextInput::make('data.eyebrow')->label('Eyebrow label'),
                        Forms\Components\TextInput::make('data.heading')->label('Heading'),
                        Forms\Components\Textarea::make('data.intro')->label('Intro paragraph')->rows(2)->columnSpanFull(),
                        Forms\Components\Repeater::make('data.destinations')
                            ->label('Destinations')
                            ->schema([
                                Forms\Components\TextInput::make('name')->label('Name'),
                                Forms\Components\TextInput::make('desc')->label('Short description'),
                                CuratorPicker::make('image_media_id')
                                    ->label('Image (pick / upload)')
                                    ->buttonLabel('Pick / upload image')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        $media = is_array($state) ? reset($state) : null;
                                        if ($media) { $set('image', $media['url'] ?? null); }
                                    }),
                                Forms\Components\TextInput::make('image')->label('Image URL (auto-filled or manual)'),
                                Forms\Components\TextInput::make('link')->label('Link URL'),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]))
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'destinations-list'),

                // ── journey-grid ─────────────────────────────────────────
                Forms\Components\Section::make('Religious journeys grid content')
                    ->schema(static::dehydrateWhen('journey-grid', [
                        Forms\Components\TextInput::make('data.eyebrow')->label('Eyebrow label'),
                        Forms\Components\TextInput::make('data.heading')->label('Heading'),
                        Forms\Components\Textarea::make('data.intro')->label('Intro paragraph')->rows(2)->columnSpanFull(),
                        Forms\Components\Repeater::make('data.journeys')
                            ->label('Journeys')
                            ->schema([
                                Forms\Components\TextInput::make('name')->label('Name'),
                                Forms\Components\Textarea::make('desc')->label('Description')->rows(2)->columnSpan(2),
                                CuratorPicker::make('image_media_id')
                                    ->label('Image (pick / upload)')
                                    ->buttonLabel('Pick / upload image')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        $media = is_array($state) ? reset($state) : null;
                                        if ($media) { $set('image', $media['url'] ?? null); }
                                    }),
                                Forms\Components\TextInput::make('image')->label('Image URL (auto-filled or manual)'),
                                Forms\Components\TextInput::make('href')->label('Link URL'),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]))
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'journey-grid'),

                // ── payment ──────────────────────────────────────────────
                Forms\Components\Section::make('Payment options content')
                    ->schema(static::dehydrateWhen('payment', [
                        Forms\Components\TextInput::make('data.eyebrow')->label('Eyebrow label'),
                        Forms\Components\TextInput::make('data.heading')->label('Heading'),
                        Forms\Components\Textarea::make('data.body')->label('Body paragraph')->rows(2)->columnSpanFull(),
                        Forms\Components\TextInput::make('data.disclaimer')->label('Disclaimer text')->columnSpanFull(),
                        Forms\Components\TextInput::make('data.link_label')->label('Link label'),
                        Forms\Components\TextInput::make('data.link_href')->label('Link URL'),
                        Forms\Components\TextInput::make('data.panel_label')->label('Panel label')->columnSpanFull(),
                        Forms\Components\Repeater::make('data.logos')
                            ->label('Payment logos')
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->label('Label / name')
                                    ->required()
                                    ->columnSpanFull(),
                                CuratorPicker::make('image_media_id')
                                    ->label('Logo image (optional)')
                                    ->buttonLabel('Pick / upload image')
                                    ->live()
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        $media = is_array($state) ? reset($state) : null;
                                        if ($media) { $set('image', $media['url'] ?? null); }
                                    }),
                                Forms\Components\TextInput::make('image')
                                    ->label('Image URL (auto-filled or manual)'),
                                static::iconField(),
                                Forms\Components\Placeholder::make('_logo_hint')
                                    ->label('')
                                    ->content('Leave image and icon both empty to just show the label as plain text, like before.')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->defaultItems(2)
                            ->reorderable()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('data.accepted_label')->label('"Also accepted" label'),
                        Forms\Components\TextInput::make('data.accepted_text')->label('"Also accepted" text'),
                    ]))
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'payment'),

                // ── reviews ──────────────────────────────────────────────
                Forms\Components\Section::make('Review content')
                    ->schema(static::dehydrateWhen('reviews', [
                        Forms\Components\TextInput::make('data.eyebrow')->label('Eyebrow label'),
                        Forms\Components\TextInput::make('data.heading')->label('Heading'),
                        Forms\Components\Textarea::make('data.quote')->label('Quote')->rows(3)->columnSpanFull(),
                        Forms\Components\TextInput::make('data.author')->label('Author / attribution')->columnSpanFull(),
                    ]))
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'reviews'),

                // ── process ──────────────────────────────────────────────
                Forms\Components\Section::make('How it works content')
                    ->schema(static::dehydrateWhen('process', [
                        Forms\Components\TextInput::make('data.eyebrow')->label('Eyebrow label'),
                        Forms\Components\TextInput::make('data.heading')->label('Heading'),
                        Forms\Components\Repeater::make('data.steps')
                            ->label('Steps')
                            ->schema([
                                Forms\Components\TextInput::make('number')->label('Number (e.g. 01)'),
                                Forms\Components\TextInput::make('title')->label('Title'),
                                Forms\Components\Textarea::make('body')->label('Body')->rows(2)->columnSpan(2),
                            ])
                            ->columns(2)
                            ->defaultItems(3)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]))
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'process'),

                // ── about-story ──────────────────────────────────────────
                Forms\Components\Section::make('About story content')
                    ->schema(static::dehydrateWhen('about-story', [
                        Forms\Components\TextInput::make('data.eyebrow')->label('Eyebrow label'),
                        Forms\Components\TextInput::make('data.heading')->label('Heading'),
                        Forms\Components\Textarea::make('data.paragraph1')->label('Paragraph 1')->rows(2)->columnSpanFull(),
                        Forms\Components\Textarea::make('data.paragraph2')->label('Paragraph 2')->rows(2)->columnSpanFull(),
                        Forms\Components\Repeater::make('data.story_cards')
                            ->label('Small stat cards')
                            ->schema([
                                Forms\Components\TextInput::make('title')->label('Title'),
                                Forms\Components\TextInput::make('body')->label('Body'),
                            ])
                            ->columns(2)
                            ->defaultItems(3)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]))
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'about-story'),

                // ── blog-preview ─────────────────────────────────────────
                Forms\Components\Section::make('Blog preview content')
                    ->schema(static::dehydrateWhen('blog-preview', [
                        Forms\Components\TextInput::make('data.eyebrow')->label('Eyebrow label'),
                        Forms\Components\TextInput::make('data.heading')->label('Heading'),
                        Forms\Components\TextInput::make('data.link_label')->label('Link label'),
                        Forms\Components\Placeholder::make('_blog_hint')
                            ->label('')
                            ->content('The post cards themselves are pulled automatically from the blog — only the heading and link above are editable here.')
                            ->columnSpanFull(),
                    ]))
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'blog-preview'),

                // ── support ("The Fly Quick difference") ────────────────
                Forms\Components\Section::make('Support / difference content')
                    ->schema(static::dehydrateWhen('support', [
                        Forms\Components\TextInput::make('data.eyebrow')->label('Eyebrow label'),
                        Forms\Components\TextInput::make('data.heading')->label('Heading'),
                        Forms\Components\Textarea::make('data.intro')->label('Intro paragraph')->rows(2)->columnSpanFull(),
                        Forms\Components\TextInput::make('data.stat_number')->label('Stat number (e.g. 7)'),
                        Forms\Components\TextInput::make('data.stat_label')->label('Stat label (two lines, separate with |)')->placeholder('days a week|support'),
                        Forms\Components\TextInput::make('data.note1')->label('Orbit note 1'),
                        Forms\Components\TextInput::make('data.note2')->label('Orbit note 2'),
                        Forms\Components\TextInput::make('data.note3')->label('Orbit note 3'),
                        Forms\Components\Repeater::make('data.checklist')
                            ->label('Checklist items')
                            ->simple(Forms\Components\TextInput::make('item'))
                            ->defaultItems(4)
                            ->reorderable()
                            ->columnSpanFull(),
                    ]))
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'support'),

                // ── contact ──────────────────────────────────────────────
                Forms\Components\Section::make('Contact section content')
                    ->schema(static::dehydrateWhen('contact', [
                        Forms\Components\TextInput::make('data.heading')->label('Heading')->columnSpanFull(),
                        Forms\Components\Select::make('data.default_travel_type')
                            ->label('Pre-select "How can we help?" to')
                            ->options([
                                'Hotels'                     => 'Hotels',
                                'Holiday package'            => 'Holiday package',
                                'Corporate travel'           => 'Corporate travel',
                                'Umrah or religious travel'  => 'Umrah or religious travel',
                                'Flights'                    => 'Flights',
                            ])
                            ->placeholder('No pre-selection (default)')
                            ->columnSpanFull(),
                        Forms\Components\Placeholder::make('_contact_hint')
                            ->label('')
                            ->content('Phone, email, WhatsApp and hours come from the site-wide SITE_* config/env values, not this form. The remaining form fields are not editable here.')
                            ->columnSpanFull(),
                    ]))
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'contact'),

            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('section_type')
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable()
                    ->width('50px'),
                Tables\Columns\BadgeColumn::make('section_type')
                    ->label('Type')
                    ->formatStateUsing(fn (string $state) => str($state)->title()->replace('-', ' ')),
                Tables\Columns\TextColumn::make('heading')
                    ->label('Heading / Name')
                    ->getStateUsing(fn ($record) =>
                        $record->data['heading'] ?? $record->data['name'] ?? '—'
                    )
                    ->limit(60),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add section')
                    ->modalWidth('4xl')
                    ->mutateFormDataUsing(fn (array $data): array => static::cleanSectionData($data)),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('4xl')
                    ->mutateFormDataUsing(fn (array $data): array => static::cleanSectionData($data)),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
