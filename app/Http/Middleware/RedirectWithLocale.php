<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectWithLocale
{
    public function handle($request, Closure $next)
    {
        // Get the locale from the route or default to 'ar' if missing
        $locale = $request->route('locale') ?? 'ar';

        // Check if user is not authenticated
        if (!Auth::check()) {
            // Redirect to login with locale as a route parameter
            return redirect()->route('login', ['locale' => $locale]);
        }

        return $next($request);
    }
}
