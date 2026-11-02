<?php

namespace App\Http\Controllers;

use App\Models\ContactEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EnquiryController extends Controller
{
    public function store(Request $request)
    {
        // Honeypot spam check
        if ($request->filled('company')) {
            return redirect()->back();
        }

        // reCAPTCHA v3 validation (skip if not configured)
        $siteKey = config('recaptcha.api_site_key');
        if (! empty($siteKey)) {
            $token = $request->input('g-recaptcha-response');
            $result = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => config('recaptcha.api_secret_key'),
                'response' => $token,
                'remoteip' => $request->ip(),
            ])->json();

            if (! ($result['success'] ?? false) || ($result['score'] ?? 0) < 0.5) {
                return redirect()->back()->withErrors(['recaptcha' => 'Verification failed. Please try again.'])->withInput();
            }
        }

        $data = $request->validate([
            'name'        => 'required|string|min:2|max:255',
            'email'       => 'required|email|max:255',
            'phone'       => 'required|string|min:8|max:50',
            'travel_type' => 'nullable|string|max:100',
            'message'     => 'required|string|min:10',
            'consent'     => 'required|accepted',
        ]);

        $data['subject'] = trim(
            ($request->input('origin') ? $request->input('origin') . ' → ' : '')
            . ($request->input('destination') ?: '')
            . ($request->input('dates') ? ' · ' . $request->input('dates') : '')
        ) ?: null;

        ContactEnquiry::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'phone'       => $data['phone'],
            'travel_type' => $data['travel_type'] ?? null,
            'subject'     => $data['subject'],
            'message'     => $data['message'],
        ]);

        return redirect()->back()->with('enquiry_sent', true);
    }
}
