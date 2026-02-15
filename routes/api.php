<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

