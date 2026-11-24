<?php

namespace App\Providers;

use App\Models\Setting;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->applySiteSettingsOverrides();

        // Copyright footer on all simple (auth) pages — login, 2FA challenge etc.
        FilamentView::registerRenderHook(
            PanelsRenderHook::SIMPLE_PAGE_END,
            fn (): string => Blade::render('
                <p style="margin-top:1.5rem;text-align:center;font-size:.75rem;color:rgb(156 163 175);">
                    &copy; ' . date('Y') . ' Fly Quick. All rights reserved.<br>
                    Powered by <a href="https://mbilalkhan.me" target="_blank" rel="noopener"
                        style="color:rgb(245 158 11);text-decoration:none;">mbilalkhan.me</a>
                </p>
            ')
        );

        // Inject reCAPTCHA v3 script + hidden token on the Filament login page
        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_END,
            function (): string {
                $siteKey = config('recaptcha.api_site_key', '');
                if (empty($siteKey) || ! request()->routeIs('filament.admin.auth.login')) {
                    return '';
                }
                return Blade::render(<<<BLADE
                    <script src="https://www.google.com/recaptcha/api.js?render={$siteKey}"></script>
                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var form = document.querySelector('form');
                        if (!form) return;
                        var btn = form.querySelector('[type=submit]');

                        form.addEventListener('submit', function (e) {
                            e.preventDefault();

                            var wireEl = form.closest('[wire\\\\:id]');
                            if (!wireEl || !window.Livewire) return;
                            var component = window.Livewire.find(wireEl.getAttribute('wire:id'));

                            if (btn) btn.disabled = true;
                            grecaptcha.ready(function () {
                                grecaptcha.execute('{$siteKey}', {action: 'login'}).then(function (token) {
                                    // Stash the token on the Livewire component itself — Livewire's
                                    // AJAX submit only sends wire:model-bound state, never raw DOM
                                    // inputs, so a plain hidden field + form.submit() would bypass
                                    // Livewire and hit a route that only accepts GET (405).
                                    component.set('recaptchaToken', token).then(function () {
                                        component.call('authenticate').finally(function () {
                                            if (btn) btn.disabled = false;
                                        });
                                    });
                                });
                            });
                        });
                    });
                    </script>
                BLADE);
            }
        );
    }

    /**
     * Business contact details and custom script snippets are editable from
     * Admin → Site Settings. Where a setting has been filled in, it overrides
     * the env-based default in config/site.php — this runs on every request
     * (not baked into `config:cache`), so admin edits show up immediately.
     */
    private function applySiteSettingsOverrides(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        $map = [
            'site_phone' => 'phone',
            'site_phone_href' => 'phone_href',
            'site_email' => 'email',
            'site_whatsapp' => 'whatsapp',
            'site_hours' => 'hours',
            'header_scripts' => 'header_scripts',
            'body_scripts' => 'body_scripts',
            'footer_scripts' => 'footer_scripts',
        ];

        $values = Setting::whereIn('key', array_keys($map))->pluck('value', 'key');

        foreach ($map as $settingKey => $configKey) {
            if (filled($values[$settingKey] ?? null)) {
                config(["site.{$configKey}" => $values[$settingKey]]);
            }
        }
    }
}
