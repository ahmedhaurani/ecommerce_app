<?php

use App\Http\Middleware\LocaleMiddleware;
use App\Http\Middleware\RedirectToLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SetLocale;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',

        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Append the RedirectToLocale middleware to the 'web' group
        // $middleware->appendToGroup('web', RedirectToLocale::class);
        // $middleware->appendToGroup('web', SetLocale::class);
        // $middleware->appendToGroup('web', \App\Http\Middleware\AddLocaleToUrls::class);

        // Add Sanctum middleware to the 'api' group
        $middleware->appendToGroup('api', EnsureFrontendRequestsAreStateful::class);

        // Add other custom middleware as needed
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
