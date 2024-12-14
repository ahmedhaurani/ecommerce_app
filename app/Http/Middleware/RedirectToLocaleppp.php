<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectToLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip redirect if the request is an AJAX or Livewire request
        if ($request->ajax() || $request->header('X-Livewire')) {
            return $next($request);
        }

        // Check if the first segment is a locale (en or ar)
        $locale = $request->segment(1);

        // Redirect to default locale if missing
        if (!$locale || !in_array($locale, ['en', 'ar'])) {
            $locale = session('user_locale', 'ar'); // Use session locale or default to 'ar'
            return redirect("/{$locale}{$request->getPathInfo()}");
        }

        // Store the locale in session for future use
        session(['user_locale' => $locale]);

        // Set the application locale
        app()->setLocale($locale);

        return $next($request);
    }
}
