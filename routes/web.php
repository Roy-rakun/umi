<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController; // Kept AuthController as it's used later
use App\Http\Controllers\LandingController; // Kept LandingController as it's used later

Route::get('/', [LandingController::class, 'index'])->name('home');

// Affiliate Referral Link Route (short link format)
Route::get('/ref/{code}', [LandingController::class, 'handleReferralLink'])->name('affiliate.referral');
Route::get('/checkout/{productId}', [LandingController::class, 'checkout'])->name('checkout');
Route::post('/checkout/{productId}', [LandingController::class, 'processCheckout'])->name('checkout.process');
Route::get('/products', [LandingController::class, 'products'])->name('products.index');
Route::get('/p/{slug}', [LandingController::class, 'showPage'])->name('page.show');


// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/register/success', [AuthController::class, 'registrationSuccess'])->name('register.success');

// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/affiliates', [AdminController::class, 'affiliates'])->name('affiliates');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [AdminController::class, 'orderDetail'])->name('orders.detail');
    Route::post('/orders/{id}/cancel', [AdminController::class, 'cancelOrder'])->name('orders.cancel');
    Route::delete('/orders/{id}', [AdminController::class, 'deleteOrder'])->name('orders.destroy');
    
    // Page Management
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

    // Product Management
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::post('/products/{product}/reorder/{direction}', [\App\Http\Controllers\ProductController::class, 'reorder'])->name('products.reorder');
    Route::get('/commissions', [AdminController::class, 'commissions'])->name('commissions');
    Route::get('/payouts', [AdminController::class, 'payouts'])->name('payouts');
    Route::post('/payouts/{id}/approve', [AdminController::class, 'approvePayout'])->name('payouts.approve');
    Route::post('/payouts/{id}/reject', [AdminController::class, 'rejectPayout'])->name('payouts.reject');
    Route::post('/payouts/{id}/complete', [AdminController::class, 'completePayout'])->name('payouts.complete');
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::get('/fraud-logs', [AdminController::class, 'fraudLogs'])->name('fraud_logs');
    Route::post('/notifications/read', [AdminController::class, 'markNotificationsAsRead'])->name('notifications.read');
    

    // Landing Page Sections
    Route::prefix('landing')->name('landing.')->group(function() {
        Route::resource('sections', \App\Http\Controllers\Admin\LandingSectionController::class)->only(['index', 'edit', 'update']);
        Route::post('sections/{section}/reorder/{direction}', [\App\Http\Controllers\Admin\LandingSectionController::class, 'reorder'])->name('sections.reorder');
    });

    // Manual Verification
    Route::post('/affiliates/verify-all', [AdminController::class, 'verifyAllAffiliates'])->name('affiliates.verify-all');
    Route::post('/affiliates/{id}/verify', [AdminController::class, 'verifyAffiliate'])->name('affiliates.verify');
    
    // Affiliate Management Actions
    Route::post('/affiliates/{id}/suspend', [AdminController::class, 'suspendAffiliate'])->name('affiliates.suspend');
    Route::post('/affiliates/{id}/unsuspend', [AdminController::class, 'unsuspendAffiliate'])->name('affiliates.unsuspend');
    Route::post('/affiliates', [AdminController::class, 'storeAffiliate'])->name('affiliates.store');
    Route::post('/affiliates/{id}/update-group', [AdminController::class, 'updateAffiliateGroup'])->name('affiliates.update-group');
    Route::post('/affiliates/bulk-action', [AdminController::class, 'bulkActionAffiliates'])->name('affiliates.bulk-action');
    Route::delete('/affiliates/{id}', [AdminController::class, 'deleteAffiliate'])->name('affiliates.destroy');
});

// Affiliate Routes
Route::prefix('affiliate')->name('affiliate.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile');
    Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/dashboard', [AffiliateController::class, 'index'])->name('dashboard');
    Route::get('/my-links', [AffiliateController::class, 'myLinks'])->name('my_links');
    Route::get('/performance', [AffiliateController::class, 'performance'])->name('performance');
    Route::get('/commissions', [AffiliateController::class, 'commissions'])->name('commissions');
    Route::get('/payouts', [AffiliateController::class, 'payouts'])->name('payouts');
    Route::post('/payouts/request', [AffiliateController::class, 'requestPayout'])->name('payouts.request');
    Route::get('/marketing-assets', [AffiliateController::class, 'marketingAssets'])->name('marketing_assets');
    Route::get('/academy', [AffiliateController::class, 'academy'])->name('academy');
    
    // Notification routes
    Route::get('/notifications', [AffiliateController::class, 'notifications'])->name('notifications.index');
    Route::get('/notifications/mark-all-read', [AffiliateController::class, 'markAllNotificationsAsRead'])->name('notifications.mark-all-read');
});

// Region API Routes (for cascading dropdowns)
Route::prefix('api/regions')->group(function () {
    Route::get('/cities/{provinceCode}', [ProfileController::class, 'getCities']);
    Route::get('/districts/{cityCode}', [ProfileController::class, 'getDistricts']);
    Route::get('/villages/{districtCode}', [ProfileController::class, 'getVillages']);
});

// Fallback for Dynamic Pages (Must be at the very end)
Route::get('/{slug}', [LandingController::class, 'showPage'])->name('page.direct');
