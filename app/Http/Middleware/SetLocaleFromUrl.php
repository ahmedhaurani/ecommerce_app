<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Support\Facades\App;
// use Illuminate\Support\Facades\Route;

// class SetLocaleFromUrl
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  \Closure  $next
//      * @return mixed
//      */
//     public function handle($request, Closure $next)
//     {
//         // Get the 'locale' parameter from the route
//         $locale = $request->route('locale');

//         // If 'locale' is present and valid, set it as the application locale
//         if ($locale && in_array($locale, ['en', 'ar'])) {
//             App::setLocale($locale);
//         } else {
//             // If 'locale' is missing, redirect to default locale (e.g., 'en')
//             $defaultLocale = 'en';
//             $parameters = array_merge($request->route()->parameters(), ['locale' => $defaultLocale]);
//             return redirect()->route(Route::currentRouteName(), $parameters);
//         }

//         return $next($request);
//     }
// }


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocaleFromUrl
{
    public function handle($request, Closure $next)
    {
        // Get the 'locale' from the URL
        $locale = $request->route('locale');

        // Check if the locale is valid (e.g., 'en' or 'ar') and set it
        if (in_array($locale, ['en', 'ar'])) {
            App::setLocale($locale); // Set Laravel's application locale
        } else {
            // Fallback to default locale if the URL parameter is missing or invalid
            App::setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
