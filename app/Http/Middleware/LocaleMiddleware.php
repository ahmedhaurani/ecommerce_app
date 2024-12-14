<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;

// class LocaleMiddleware
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//     // public function handle(Request $request, Closure $next): Response
//     // {
//     //     return $next($request);
//     // }

//     public function handle($request, Closure $next)
// {
//     $locale = session()->get('locale', config('app.locale'));
//     app()->setLocale($locale);

//     $direction = in_array($locale, ['ar']) ? 'rtl' : 'ltr';
//     app()->config->set('app.direction', $direction);

//     return $next($request);
// }
// }



namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale           = $request->segment(1);
        $supportedLocales = explode('|', config('app.supported_locales'));

        if (in_array($locale, $supportedLocales)) {
            App::setLocale($locale);
        } else {
            App::setLocale(config('app.locale'));  // Default to primary language if not specified
        }

        return $next($request);
    }
}
