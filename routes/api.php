<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Region Data
Route::get('/regions/cities/{province}', [App\Http\Controllers\ProfileController::class, 'getCities']);
Route::get('/regions/districts/{city}', [App\Http\Controllers\ProfileController::class, 'getDistricts']);
Route::get('/regions/villages/{district}', [App\Http\Controllers\ProfileController::class, 'getVillages']);

// Shipping

// Webhooks
Route::post('/webhook/mayar', [App\Http\Controllers\WebhookController::class, 'handleMayar'])->name('api.webhook.mayar');

