<?php

namespace App\Providers;

use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
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
                        form.addEventListener('submit', function (e) {
                            e.preventDefault();
                            var btn = form.querySelector('[type=submit]');
                            if (btn) btn.disabled = true;
                            grecaptcha.ready(function () {
                                grecaptcha.execute('{$siteKey}', {action: 'login'}).then(function (token) {
                                    var input = document.createElement('input');
                                    input.type = 'hidden';
                                    input.name = 'g-recaptcha-response-v3';
                                    input.value = token;
                                    form.appendChild(input);
                                    if (btn) btn.disabled = false;
                                    form.submit();
                                });
                            });
                        });
                    });
                    </script>
                BLADE);
            }
        );
    }
}
