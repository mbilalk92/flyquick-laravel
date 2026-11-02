<?php

use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TwoFactorController;
use Illuminate\Support\Facades\Route;

// Contact form submission
Route::post('/send-enquiry', [EnquiryController::class, 'store'])->name('enquiry.store');

// Admin 2FA challenge (runs before full auth, so no auth middleware)
Route::get('/admin/two-factor', [TwoFactorController::class, 'show'])->name('two-factor.show');
Route::post('/admin/two-factor', [TwoFactorController::class, 'verify'])->name('two-factor.verify');
Route::post('/admin/two-factor/send-email', [TwoFactorController::class, 'sendEmail'])->name('two-factor.send-email');

// Homepage
Route::get('/', [PageController::class, 'home'])->name('home');

// Catch-all slug resolver — must be last
// Matches single and multi-segment slugs (flights, location/pakistan, religious-tours/group-umrah, etc.)
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '[a-zA-Z0-9\-\/]+')
    ->name('page.show');
