<x-filament-panels::page.simple>
    <x-filament-panels::form wire:submit="verify">
        <div class="fi-simple-page-heading">
            <p class="text-sm text-center text-gray-500 dark:text-gray-400">
                @if($method === 'email')
                    Enter the 6-digit code sent to your email address.
                @else
                    Open your authenticator app and enter the 6-digit code.
                @endif
            </p>
        </div>

        {{ $this->form }}

        <x-filament::button type="submit" class="w-full">
            Verify
        </x-filament::button>

        <div class="flex flex-col gap-2 mt-2">
            @if($method === 'totp')
                <x-filament::button
                    wire:click="sendEmailCode"
                    color="gray"
                    outlined
                    class="w-full"
                >
                    Send code to my email instead
                </x-filament::button>
            @else
                <x-filament::button
                    wire:click="switchToTotp"
                    color="gray"
                    outlined
                    class="w-full"
                >
                    Use authenticator app instead
                </x-filament::button>
                <x-filament::button
                    wire:click="sendEmailCode"
                    color="gray"
                    outlined
                    class="w-full"
                >
                    Resend email code
                </x-filament::button>
            @endif
        </div>

        <p class="text-xs text-center text-gray-400 mt-2">
            <a href="{{ filament()->getLoginUrl() }}" class="underline">Back to login</a>
        </p>
    </x-filament-panels::form>
</x-filament-panels::page.simple>
