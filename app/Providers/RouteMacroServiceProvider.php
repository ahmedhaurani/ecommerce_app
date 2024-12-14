<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Route::macro('localized', function ($group) {
            $supportedLocales = config('app.supported_locales');
            // Default route without prefix (default to default language)
            Route::group([], $group);

            // Language prefixed routes
            Route::group(['prefix' => '{local}', 'where'=> ['local' => $supportedLocales]], $group);
        });
    }
}
