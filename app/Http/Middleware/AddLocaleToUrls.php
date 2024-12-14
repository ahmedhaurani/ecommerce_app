<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Support\Facades\App;
// use Illuminate\Support\Facades\URL;

// class AddLocaleToUrls
// {

//     public function handle($request, Closure $next)
//     {        $locale = $request->segment(1);

//         // Set the default URL format to include the locale
//         URL::defaults(['locale' => $locale]);

//         return $next($request);
//     }
// }


// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\URL;

// class AddLocaleToUrls
// {
//     public function handle($request, Closure $next)
//     {
//         // Retrieve the locale from the session, or use the default if not set
//         $locale = Session::get('locale', config('app.locale'));

//         // Set the default URL format to include the locale
//         URL::defaults(['locale' => $locale]);

//         return $next($request);
//     }
// }

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class AddLocaleToUrls
{
    public function handle($request, Closure $next)
    {
        // Get the locale from session or default to config locale
        $locale = Session::get('locale', config('app.locale'));

        // Set default locale for URL generation
        URL::defaults(['locale' => $locale]);

        return $next($request);
    }
}
