<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Support\Facades\App;

// class SetLocale
// {
//     public function handle($request, Closure $next)
//     {
//         $locale = $request->segment(1); // Get the first segment of the URL
//         if (in_array($locale, ['en', 'ar'])) { // Check if it's a supported locale
//             App::setLocale($locale); // Set application locale
//         } else {
//             App::setLocale('en'); // Default to English
//         }

//         return $next($request);
//     }
// }


// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Support\Facades\App;

// class SetLocale
// {
//     public function handle($request, Closure $next)
//     {
//         $locale = $request->route('locale'); // Get locale from the URL segment
//         if (in_array($locale, ['en', 'ar'])) {
//             App::setLocale($locale); // Set the application locale
//             session(['locale' => $locale]); // Store locale in session for persistence
//         } else {
//             // Default to session locale or English if no valid locale
//             $locale = session('locale', 'en');
//             App::setLocale($locale);
//         }

//         return $next($request);
//     }
// }
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{

    public function handle($request, Closure $next)
{
    $locale = $request->route('locale') ?? config('app.locale');
    app()->setLocale($locale);
    return $next($request);
}
    // public function handle($request, Closure $next)
    // {
    //     // Retrieve locale from the URL
    //     $locale = $request->route('locale');

    //     // Check if the locale is valid (e.g., 'en' or 'ar')
    //     if (in_array($locale, ['en', 'ar'])) {
    //         App::setLocale($locale);
    //         $direction = ($locale === 'ar') ? 'rtl' : 'ltr';
    //     } else {
    //         // Default fallback if no valid locale is found
    //         App::setLocale(config('app.locale'));
    //         $direction = 'ltr'; // Default direction
    //     }

    //     // Store the direction in the configuration for global access
    //     config(['app.direction' => $direction]);

    //     return $next($request);
    // }
}

