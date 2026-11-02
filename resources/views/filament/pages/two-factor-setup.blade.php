<x-filament-panels::page>

    @if($this->isEnabled())
        {{-- 2FA is ON --}}
        <x-filament::section>
            <x-slot name="heading">Two-Factor Authentication is enabled</x-slot>
            <x-slot name="description">Your account is protected with an authenticator app.</x-slot>

            <div class="flex gap-3">
                <x-filament::button wire:click="disable" color="danger" outlined>
                    Disable 2FA
                </x-filament::button>
            </div>

            @php $codes = $this->recoveryCodes() @endphp
            @if(count($codes))
                <div class="mt-6">
                    <h3 class="text-sm font-semibold mb-2">Recovery codes</h3>
                    <p class="text-xs text-gray-500 mb-3">Save these in a safe place. Each can be used once to log in if you lose your authenticator.</p>
                    <div class="grid grid-cols-2 gap-1 font-mono text-sm bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                        @foreach($codes as $code)
                            <span>{{ $code }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </x-filament::section>

    @else
        {{-- 2FA is OFF — show setup --}}
        <x-filament::section>
            <x-slot name="heading">Set up Two-Factor Authentication</x-slot>
            <x-slot name="description">Scan the QR code with Google Authenticator, Authy, or any TOTP app.</x-slot>

            <div class="flex flex-col items-start gap-6">
                <div class="bg-white p-4 rounded-lg shadow-sm border">
                    {!! $this->qrCode() !!}
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Or enter this key manually:</p>
                    <code class="text-sm font-mono bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded">
                        {{ $this->secretKey() }}
                    </code>
                </div>

                <div class="w-full max-w-xs">
                    <p class="text-sm font-medium mb-2">Enter the 6-digit code from your app to confirm:</p>
                    <div class="flex gap-2">
                        <x-filament::input.wrapper class="flex-1">
                            <x-filament::input
                                type="text"
                                wire:model="confirmCode"
                                placeholder="000000"
                                maxlength="6"
                                inputmode="numeric"
                            />
                        </x-filament::input.wrapper>
                        <x-filament::button wire:click="enable">Enable</x-filament::button>
                    </div>
                    @error('confirmCode')
                        <p class="text-sm text-danger-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </x-filament::section>
    @endif

</x-filament-panels::page>
