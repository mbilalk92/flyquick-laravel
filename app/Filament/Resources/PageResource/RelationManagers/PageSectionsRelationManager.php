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
                            'about-story' => 'About story (static)',
                        ],
                        'Travel tools' => [
                            'inner-search'   => 'Search bar (inner pages)',
                            'search'         => 'Search widget (home)',
                            'packages'       => 'Package cards',
                            'location-intro' => 'Location intro + features',
                            'journey-grid'   => 'Religious journeys grid (static)',
                        ],
                        'Discovery' => [
                            'services'          => 'Services grid (static)',
                            'destinations'      => 'Destinations grid (static)',
                            'destinations-list' => 'Destinations list (static)',
                            'offers'            => 'Offer cards',
                        ],
                        'Trust & social' => [
                            'trust-row' => 'Trust row (static)',
                            'reviews'   => 'Reviews (static)',
                            'payment'   => 'Payment options (static)',
                        ],
                        'Support' => [
                            'process' => 'How it works (static)',
                            'contact' => 'Contact form (static)',
                        ],
                        'Blog' => [
                            'blog-preview' => 'Blog preview (static)',
                        ],
                        'Home hero' => [
                            'hero' => 'Hero banner (home only, static)',
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

                // ── Static sections notice ──────────────────────────────
                Forms\Components\Placeholder::make('_static_note')
                    ->label('')
                    ->content('This section renders automatically — no data to configure.')
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => in_array($get('section_type'), [
                        'hero', 'search', 'trust-row', 'services', 'destinations',
                        'payment', 'reviews', 'blog-preview', 'process', 'inner-search',
                        'journey-grid', 'destinations-list', 'about-story', 'contact',
                    ])),

                // ── page-hero ───────────────────────────────────────────
                Forms\Components\Section::make('Page hero content')
                    ->schema([
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
                                if ($state) {
                                    $media = \Awcodes\Curator\Models\Media::find($state);
                                    if ($media) {
                                        $set('data.image_url', $media->url);
                                        if (empty($set) || true) {
                                            $set('data.image_alt', $media->alt ?? $media->name ?? '');
                                        }
                                    }
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
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'page-hero'),

                // ── breadcrumbs ─────────────────────────────────────────
                Forms\Components\Section::make('Breadcrumb trail')
                    ->schema([
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
                    ])
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'breadcrumbs'),

                // ── features ────────────────────────────────────────────
                Forms\Components\Section::make('Feature grid content')
                    ->schema([
                        Forms\Components\TextInput::make('data.heading')
                            ->label('Section heading')
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('data.items')
                            ->label('Feature items')
                            ->schema([
                                Forms\Components\TextInput::make('icon')
                                    ->label('Icon (emoji)'),
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
                    ])
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'features'),

                // ── faq ─────────────────────────────────────────────────
                Forms\Components\Section::make('FAQ content')
                    ->schema([
                        Forms\Components\TextInput::make('data.heading')
                            ->label('Section heading')
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('data.items')
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
                    ])
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'faq'),

                // ── rich-text ───────────────────────────────────────────
                Forms\Components\Section::make('Rich text content')
                    ->schema([
                        Forms\Components\RichEditor::make('data.content')
                            ->label('Content')
                            ->toolbarButtons(['bold', 'italic', 'link', 'orderedList', 'bulletList', 'h2', 'h3'])
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'rich-text'),

                // ── packages ────────────────────────────────────────────
                Forms\Components\Section::make('Package cards')
                    ->schema([
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
                                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                        if ($state) {
                                            $media = \Awcodes\Curator\Models\Media::find($state);
                                            if ($media) { $set('image', $media->url); }
                                        }
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
                    ])
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'packages'),

                // ── location-intro ──────────────────────────────────────
                Forms\Components\Section::make('Location intro content')
                    ->schema([
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
                                Forms\Components\TextInput::make('icon')->label('Icon'),
                                Forms\Components\TextInput::make('title')->label('Title'),
                                Forms\Components\Textarea::make('body')->label('Body')->rows(2)->columnSpan(2),
                            ])
                            ->columns(2)
                            ->defaultItems(4)
                            ->reorderable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'location-intro'),

                // ── offers ──────────────────────────────────────────────
                Forms\Components\Section::make('Offer cards')
                    ->schema([
                        Forms\Components\Placeholder::make('_offers_hint')
                            ->label('')
                            ->content('Leave empty to use the default Pakistan / Bali / Umrah cards.')
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('data.cards')
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
                                        if ($state) {
                                            $media = \Awcodes\Curator\Models\Media::find($state);
                                            if ($media) { $set('image', $media->url); }
                                        }
                                    }),
                                Forms\Components\TextInput::make('image')->label('Image URL (auto-filled or manual)')->columnSpan(2),
                                Forms\Components\TextInput::make('link')->label('Link URL'),
                                Forms\Components\TextInput::make('label')->label('Link label'),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->reorderable()
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->visible(fn (Get $get) => $get('section_type') === 'offers'),

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
                    ->modalWidth('4xl'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('4xl'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
