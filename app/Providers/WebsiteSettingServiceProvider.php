<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\WebsiteSetting;

class WebsiteSettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // Retrieve website settings from the database
        $settings = WebsiteSetting::first();

        // Share the settings with all views if they exist
        if ($settings) {
            View::share('websiteSettings', $settings);
        }
    }
}
