<?php
// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Support\Facades\App;

// class SetLocale
// {
//     public function handle($request, Closure $next)
//     {
//         $locale = $request->segment(1); // Get the first segment from the URL

//         // Check if the locale is one of the supported ones
//         if (in_array($locale, ['en', 'ar'])) {
//             App::setLocale($locale); // Laravel's method for setting locale
//             // Optionally, use `setlocale` only if needed
//             setlocale(LC_ALL, $locale); // Sets the PHP locale if needed
//         } else {
//             $locale = 'ar'; // Default to 'en' if locale is missing or unsupported
//             App::setLocale($locale);
//             return redirect("/$locale" . $request->getRequestUri());
//         }

//         return $next($request);
//     }
// }
// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Support\Facades\App;
// use Illuminate\Support\Facades\Session;

// class SetLocale
// {
//     public function handle($request, Closure $next)
//     {
//         // Check if the locale is provided in the URL
//         $locale = $request->route('locale');

//         // If no locale in the URL, fall back to the session value
//         if (!$locale) {
//             $locale = Session::get('locale', config('app.locale'));
//         } else {
//             // Store the locale in the session if it's in the URL
//             Session::put('locale', $locale);
//         }

//         // Set the application's locale
//         App::setLocale($locale);

//         return $next($request);
//     }
// }


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // Retrieve locale from the route, or fallback to session or config locale
        $locale = $request->route('locale') ?? Session::get('locale', config('app.locale'));

        // Set the locale for the application
        if (in_array($locale, ['en', 'ar'])) { // Adjust supported locales as needed
            App::setLocale($locale);
            Session::put('locale', $locale); // Store it in the session for future requests
        } else {
            // Default to the session locale or fallback to 'en'
            $locale = Session::get('locale', 'en');
            App::setLocale($locale);
        }

        return $next($request);
    }
}
