<?php
// use App\Http\Middleware\LocaleMiddleware;
// use Illuminate\Foundation\Application;
// use Illuminate\Foundation\Configuration\Exceptions;
// use Illuminate\Foundation\Configuration\Middleware;
// use App\Http\Middleware\SetLocale;

// return Application::configure(basePath: dirname(__DIR__))
//     ->withRouting(
//         web: __DIR__.'/../routes/web.php',
//         commands: __DIR__.'/../routes/console.php',
//         health: '/up',
//     )
//     ->withMiddleware(function (Middleware $middleware) {
//        $middleware->appendToGroup('web', SetLocale::class);


//     })
//     ->withExceptions(function (Exceptions $exceptions) {
//         //
//     })->create();



use App\Http\Middleware\LocaleMiddleware;
use App\Http\Middleware\RedirectToLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\SetLocale;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Append the RedirectToLocale middleware to the 'web' group
       // $middleware->appendToGroup('web', RedirectToLocale::class);
      //  $middleware->appendToGroup('web', SetLocale::class);
        //      $middleware->appendToGroup('web', \App\Http\Middleware\AddLocaleToUrls::class);



    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
