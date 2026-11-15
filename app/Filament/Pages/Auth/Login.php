<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Http;

class Login extends BaseLogin
{
    public ?string $recaptchaToken = null;

    public function authenticate(): ?LoginResponse
    {
        $this->validateRecaptcha();

        $response = parent::authenticate();

        // After successful auth, check if 2FA is needed
        if ($response && auth()->check()) {
            $user = auth()->user();
            if ($user->hasTwoFactorEnabled()) {
                // Store that we need 2FA challenge and log out temporarily
                session([
                    'two_factor_user_id'  => $user->getKey(),
                    'two_factor_method'   => 'totp',
                    'two_factor_remember' => request()->boolean('remember'),
                ]);
                auth()->logout();
                $this->redirect(route('two-factor.show'));
                return null;
            }
        }

        return $response;
    }

    protected function validateRecaptcha(): void
    {
        $siteKey = config('recaptcha.api_site_key');

        // Skip validation if no site key configured yet
        if (empty($siteKey)) {
            return;
        }

        $token = $this->recaptchaToken;

        if (empty($token)) {
            throw ValidationException::withMessages([
                'data.email' => 'reCAPTCHA verification failed. Please refresh and try again.',
            ]);
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('recaptcha.api_secret_key'),
            'response' => $token,
            'remoteip' => request()->ip(),
        ]);

        $result = $response->json();

        if (! ($result['success'] ?? false) || ($result['score'] ?? 0) < 0.5) {
            throw ValidationException::withMessages([
                'data.email' => 'reCAPTCHA verification failed. Please try again.',
            ]);
        }
    }

    public function getExtraBodyAttributes(): array
    {
        return ['class' => 'recaptcha-page'];
    }
}
