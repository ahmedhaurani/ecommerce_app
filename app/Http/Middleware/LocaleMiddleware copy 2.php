<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Step 1: Check for 'locale' in the URL
        $locale = $request->route('locale');

        // Step 2: If not present in URL, fall back to session-stored locale or default config
        if (!$locale || !in_array($locale, ['en', 'ar'])) {
            $locale = session()->get('locale', config('app.locale'));
        }

        // Step 3: Set the locale for the application
        app()->setLocale($locale);

        // Step 4: Store the locale in the session for future requests
        session()->put('locale', $locale);

        // Step 5: Set text direction based on locale (e.g., 'rtl' for Arabic, 'ltr' for English)
        $direction = ($locale === 'ar') ? 'rtl' : 'ltr';
        config()->set('app.direction', $direction);

        return $next($request);
    }
}
