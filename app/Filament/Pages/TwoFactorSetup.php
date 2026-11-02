<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Validation\ValidationException;

class TwoFactorSetup extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Two-Factor Auth';
    protected static ?string $navigationGroup = 'Account';
    protected static ?int $navigationSort = 99;
    protected static string $view = 'filament.pages.two-factor-setup';

    public ?string $confirmCode = null;

    public function getUser()
    {
        return auth()->user();
    }

    public function isEnabled(): bool
    {
        return $this->getUser()->hasTwoFactorEnabled();
    }

    public function qrCode(): string
    {
        return $this->getUser()->createTwoFactorAuth()->toQr();
    }

    public function secretKey(): string
    {
        return $this->getUser()->createTwoFactorAuth()->toString();
    }

    public function enable(): void
    {
        $this->validate(['confirmCode' => 'required|digits:6']);

        $user = $this->getUser();

        if (! $user->confirmTwoFactorAuth($this->confirmCode)) {
            throw ValidationException::withMessages(['confirmCode' => 'Invalid code — please try again.']);
        }

        $this->confirmCode = null;

        Notification::make()->title('Two-factor authentication enabled.')->success()->send();
    }

    public function disable(): void
    {
        $this->getUser()->disableTwoFactorAuth();

        Notification::make()->title('Two-factor authentication disabled.')->warning()->send();
    }

    public function recoveryCodes(): array
    {
        return $this->getUser()->getRecoveryCodes() ?? [];
    }
}
