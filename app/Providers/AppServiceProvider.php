<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            // Share settings with all views if table exists
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $settings = \App\Models\Setting::all()->pluck('value', 'key');
                \Illuminate\Support\Facades\View::share('settings', $settings);
            }
        } catch (\Exception $e) {
            // Log::error('Failed to share settings: ' . $e->getMessage());
        }
    }
}
