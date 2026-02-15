<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

// Test Shipping Calculate (for debugging)
Route::get('/test-shipping-calc', function (Request $request) {
    try {
        $service = new \App\Services\IndonesiaExpeditionService();
        $result = $service->calculateCost(
            $request->input('village_code', '31.73.05.1006'),
            $request->input('weight', 1000)
        );
        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});

// Region Data
Route::get('/regions/provinces', [App\Http\Controllers\ProfileController::class, 'getProvinces']);
Route::get('/regions/cities/{province}', [App\Http\Controllers\ProfileController::class, 'getCities']);
Route::get('/regions/districts/{city}', [App\Http\Controllers\ProfileController::class, 'getDistricts']);
Route::get('/regions/villages/{district}', [App\Http\Controllers\ProfileController::class, 'getVillages']);

// Shipping
Route::get('/shipping/provinces', [App\Http\Controllers\ShippingController::class, 'getProvinces']);
Route::get('/shipping/cities/{provinceId}', [App\Http\Controllers\ShippingController::class, 'getCities']);
Route::post('/shipping/calculate', [App\Http\Controllers\ShippingController::class, 'calculate']);
Route::post('/shipping/calculate-legacy', [App\Http\Controllers\ShippingController::class, 'calculateLegacy']);

// Webhooks
Route::post('/webhook/mayar', [App\Http\Controllers\WebhookController::class, 'handleMayar'])->name('api.webhook.mayar');

