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
            'site_name', 'site_tagline', 'site_email', 'site_phone',
            'site_address', 'site_logo', 'site_favicon',
            'header_announcement', 'footer_copyright',
            'social_facebook', 'social_instagram', 'social_twitter',
            'meta_title_suffix', 'google_analytics_id',
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
                        Forms\Components\TextInput::make('site_email')->email()->label('Contact Email'),
                        Forms\Components\TextInput::make('site_phone')->label('Phone Number'),
                        Forms\Components\Textarea::make('site_address')->rows(2)->label('Address'),
                    ])->columns(2),

                Forms\Components\Section::make('Branding')
                    ->schema([
                        Forms\Components\TextInput::make('site_logo')->label('Logo URL'),
                        Forms\Components\TextInput::make('site_favicon')->label('Favicon URL'),
                    ])->columns(2),

                Forms\Components\Section::make('Header & Footer')
                    ->schema([
                        Forms\Components\TextInput::make('header_announcement')
                            ->label('Header Announcement Bar')
                            ->helperText('Leave blank to hide the bar'),
                        Forms\Components\TextInput::make('footer_copyright')->label('Footer Copyright Text'),
                    ])->columns(2),

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
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $groups = [
            'site_name' => 'general', 'site_tagline' => 'general',
            'site_email' => 'general', 'site_phone' => 'general',
            'site_address' => 'general', 'site_logo' => 'general',
            'site_favicon' => 'general', 'header_announcement' => 'header',
            'footer_copyright' => 'footer', 'social_facebook' => 'general',
            'social_instagram' => 'general', 'social_twitter' => 'general',
            'meta_title_suffix' => 'seo', 'google_analytics_id' => 'seo',
        ];

        foreach ($data as $key => $value) {
            Setting::set($key, $value, $groups[$key] ?? 'general');
        }

        Notification::make()->title('Settings saved')->success()->send();
    }
}
