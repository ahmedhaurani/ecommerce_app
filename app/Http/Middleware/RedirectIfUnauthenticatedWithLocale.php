<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfUnauthenticatedWithLocale
{
    public function handle($request, Closure $next, ...$guards)
    {
        // Check if the user is not authenticated
        if (Auth::guard()->guest()) {
            // Get the current locale from the route or default to the app's locale
            $locale = $request->route('locale') ?? app()->getLocale();

            // Redirect to the login route with the locale parameter
            return redirect()->route('login', ['locale' => $locale]);
        }

        return $next($request);
    }
}
