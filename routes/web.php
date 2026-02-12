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

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/affiliates', [AdminController::class, 'affiliates'])->name('affiliates');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    
    // Page Management
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

    // Product Management
    Route::resource('products', \App\Http\Controllers\ProductController::class);
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
    });
});

// Affiliate Routes
Route::prefix('affiliate')->name('affiliate.')->middleware('auth')->group(function () {
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
