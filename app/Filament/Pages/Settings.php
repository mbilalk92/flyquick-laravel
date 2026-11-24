<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string $view = 'filament.pages.settings';
    protected static ?string $navigationGroup = 'Configuration';
    protected static ?string $navigationLabel = 'Site Settings';

    public ?array $data = [];

    public function mount(): void
    {
        $keys = [
            'site_name', 'site_tagline', 'site_address', 'site_logo', 'site_favicon',
            'site_phone', 'site_phone_href', 'site_email', 'site_whatsapp', 'site_hours',
            'footer_copyright',
            'social_facebook', 'social_instagram', 'social_twitter',
            'meta_title_suffix', 'google_analytics_id',
            'header_scripts', 'body_scripts', 'footer_scripts',
        ];

        $settings = Setting::whereIn('key', $keys)->pluck('value', 'key')->toArray();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('General')
                    ->schema([
                        Forms\Components\TextInput::make('site_name')->label('Site Name'),
                        Forms\Components\TextInput::make('site_tagline')->label('Tagline'),
                        Forms\Components\Textarea::make('site_address')->rows(2)->label('Address'),
                    ])->columns(2),

                Forms\Components\Section::make('Branding')
                    ->schema([
                        Forms\Components\TextInput::make('site_logo')->label('Logo URL'),
                        Forms\Components\TextInput::make('site_favicon')->label('Favicon URL'),
                    ])->columns(2),

                Forms\Components\Section::make('Business Contact Details')
                    ->description('Used across the whole site — header, footer, contact page, hero, FAQs, etc.')
                    ->schema([
                        Forms\Components\TextInput::make('site_phone')->label('Phone Number (displayed)'),
                        Forms\Components\TextInput::make('site_phone_href')
                            ->label('Phone Link (tel:)')
                            ->placeholder('tel:+61390171800'),
                        Forms\Components\TextInput::make('site_email')->email()->label('Contact Email'),
                        Forms\Components\TextInput::make('site_whatsapp')
                            ->label('WhatsApp Link')
                            ->placeholder('https://wa.me/61390171800?text=...'),
                        Forms\Components\TextInput::make('site_hours')->label('Support Hours'),
                    ])->columns(2),

                Forms\Components\Section::make('Footer')
                    ->schema([
                        Forms\Components\TextInput::make('footer_copyright')->label('Footer Copyright Text'),
                    ]),

                Forms\Components\Section::make('Social Media')
                    ->schema([
                        Forms\Components\TextInput::make('social_facebook')->url()->label('Facebook URL'),
                        Forms\Components\TextInput::make('social_instagram')->url()->label('Instagram URL'),
                        Forms\Components\TextInput::make('social_twitter')->url()->label('Twitter / X URL'),
                    ])->columns(3),

                Forms\Components\Section::make('SEO & Analytics')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title_suffix')
                            ->label('Meta Title Suffix')
                            ->helperText('e.g. " | Fly Quick" — appended to every page title'),
                        Forms\Components\TextInput::make('google_analytics_id')
                            ->label('Google Analytics ID')
                            ->placeholder('G-XXXXXXXXXX'),
                    ])->columns(2),

                Forms\Components\Section::make('Custom Scripts')
                    ->description('Raw HTML/JS, output exactly as entered — for SEO verification tags, extra tracking pixels, etc. Leave blank unless needed.')
                    ->schema([
                        Forms\Components\Textarea::make('header_scripts')
                            ->label('Header Scripts')
                            ->helperText('Injected just before </head> on every page.')
                            ->rows(4),
                        Forms\Components\Textarea::make('body_scripts')
                            ->label('Body Scripts')
                            ->helperText('Injected right after the opening <body> tag.')
                            ->rows(4),
                        Forms\Components\Textarea::make('footer_scripts')
                            ->label('Footer Scripts')
                            ->helperText('Injected just before </body>, after all page scripts.')
                            ->rows(4),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $groups = [
            'site_name' => 'general', 'site_tagline' => 'general',
            'site_address' => 'general', 'site_logo' => 'general',
            'site_favicon' => 'general',
            'site_phone' => 'contact', 'site_phone_href' => 'contact',
            'site_email' => 'contact', 'site_whatsapp' => 'contact',
            'site_hours' => 'contact',
            'footer_copyright' => 'footer', 'social_facebook' => 'general',
            'social_instagram' => 'general', 'social_twitter' => 'general',
            'meta_title_suffix' => 'seo', 'google_analytics_id' => 'seo',
            'header_scripts' => 'scripts', 'body_scripts' => 'scripts',
            'footer_scripts' => 'scripts',
        ];

        foreach ($data as $key => $value) {
            Setting::set($key, $value, $groups[$key] ?? 'general');
        }

        Notification::make()->title('Settings saved')->success()->send();
    }
}
