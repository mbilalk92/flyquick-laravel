<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Two-Factor Authentication — Fly Quick Admin</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { min-height: 100vh; display: flex; align-items: center; justify-content: center;
               background: #f9fafb; font-family: ui-sans-serif, system-ui, sans-serif; }
        .card { background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 4px 16px rgba(0,0,0,.08);
                padding: 2rem; width: 100%; max-width: 380px; }
        .logo { text-align: center; margin-bottom: 1.5rem; }
        .logo span { font-size: 1.25rem; font-weight: 700; color: #111; }
        h1 { font-size: 1.1rem; font-weight: 600; text-align: center; margin-bottom: .5rem; }
        .subtitle { font-size: .875rem; color: #6b7280; text-align: center; margin-bottom: 1.5rem; }
        label { display: block; font-size: .875rem; font-weight: 500; color: #374151; margin-bottom: .375rem; }
        input[type=text] { width: 100%; padding: .625rem .75rem; border: 1px solid #d1d5db; border-radius: 8px;
                           font-size: 1rem; letter-spacing: .2em; text-align: center; outline: none;
                           transition: border-color .15s; }
        input[type=text]:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); }
        .error { color: #dc2626; font-size: .8rem; margin-top: .375rem; }
        .btn { display: block; width: 100%; padding: .625rem 1rem; border: none; border-radius: 8px;
               font-size: .875rem; font-weight: 600; cursor: pointer; margin-top: .75rem; transition: background .15s; }
        .btn-primary { background: #f59e0b; color: #fff; }
        .btn-primary:hover { background: #d97706; }
        .btn-outline { background: #fff; color: #374151; border: 1px solid #d1d5db; }
        .btn-outline:hover { background: #f9fafb; }
        .success-msg { background: #d1fae5; color: #065f46; font-size: .8rem; padding: .5rem .75rem;
                       border-radius: 6px; margin-bottom: 1rem; }
        .divider { text-align: center; color: #9ca3af; font-size: .8rem; margin: .75rem 0; }
        .back-link { text-align: center; margin-top: 1.25rem; font-size: .8rem; color: #9ca3af; }
        .back-link a { color: #6b7280; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo"><span>Fly Quick</span></div>
        <h1>Two-Factor Authentication</h1>
        <p class="subtitle">
            @if($method === 'email')
                Enter the 6-digit code sent to your email.
            @else
                Enter the code from your authenticator app.
            @endif
        </p>

        @if(session('email_sent'))
            <p class="success-msg">Code sent — check your inbox.</p>
        @endif

        <form method="POST" action="{{ route('two-factor.verify') }}">
            @csrf
            <div>
                <label for="code">Verification code</label>
                <input type="text" id="code" name="code" placeholder="000000"
                       maxlength="6" inputmode="numeric" autocomplete="one-time-code" autofocus
                       value="{{ old('code') }}">
                @error('code')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Verify &amp; Sign in</button>
        </form>

        <div class="divider">or</div>

        @if($method === 'totp')
            <form method="POST" action="{{ route('two-factor.send-email') }}">
                @csrf
                <button type="submit" class="btn btn-outline">Send code to my email instead</button>
            </form>
        @else
            <form method="POST" action="{{ route('two-factor.send-email') }}">
                @csrf
                <button type="submit" class="btn btn-outline">Resend email code</button>
            </form>
        @endif

        <p class="back-link">
            <a href="{{ filament()->getLoginUrl() }}">← Back to login</a>
        </p>
    </div>
</body>
</html>
