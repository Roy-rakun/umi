<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

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
        // ✅ FORCE HTTPS (penting buat Vite & asset)
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        try {
            // Share settings with all views if table exists
            if (Schema::hasTable('settings')) {
                $settings = \App\Models\Setting::all()->pluck('value', 'key');
                View::share('settings', $settings);
            }
        } catch (\Exception $e) {
            // biarin aman, ga usah crash
        }
    }
}
