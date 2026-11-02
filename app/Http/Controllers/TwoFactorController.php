<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class TwoFactorController extends Controller
{
    public function show(Request $request)
    {
        if (! session('two_factor_user_id')) {
            return redirect(filament()->getLoginUrl());
        }

        return view('auth.two-factor', [
            'method'    => session('two_factor_method', 'totp'),
            'emailSent' => session('two_factor_email_sent', false),
        ]);
    }

    public function verify(Request $request)
    {
        $userId = session('two_factor_user_id');
        if (! $userId) {
            return redirect(filament()->getLoginUrl());
        }

        $request->validate(['code' => 'required|digits:6']);

        $user   = User::findOrFail($userId);
        $method = session('two_factor_method', 'totp');
        $code   = $request->input('code');

        if ($method === 'email') {
            $cacheKey = 'two_factor_email_' . $user->getKey();
            $stored   = Cache::get($cacheKey);
            if (! $stored || $stored !== $code) {
                return back()->withErrors(['code' => 'Invalid or expired email code.']);
            }
            Cache::forget($cacheKey);
        } else {
            if (! $user->validateTwoFactorCode($code)) {
                return back()->withErrors(['code' => 'Invalid authenticator code.']);
            }
        }

        $remember = session('two_factor_remember', false);
        session()->forget(['two_factor_user_id', 'two_factor_method', 'two_factor_remember', 'two_factor_email_sent']);

        Auth::login($user, $remember);

        return redirect(filament()->getHomeUrl());
    }

    public function sendEmail(Request $request)
    {
        $userId = session('two_factor_user_id');
        if (! $userId) {
            return redirect(filament()->getLoginUrl());
        }

        $user     = User::findOrFail($userId);
        $code     = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $cacheKey = 'two_factor_email_' . $user->getKey();

        Cache::put($cacheKey, $code, now()->addMinutes(10));

        Mail::raw(
            "Your Fly Quick admin login code: {$code}\n\nThis code expires in 10 minutes.",
            fn($m) => $m->to($user->email)->subject('Your login verification code')
        );

        session(['two_factor_method' => 'email', 'two_factor_email_sent' => true]);

        return back()->with('email_sent', true);
    }
}
