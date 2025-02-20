<?php

use App\Route;
use App\RouteConst;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__.'/../routes/web.php',
            __DIR__.'/../routes/admin.php',
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);
        
        $middleware->api([
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->redirectTo(
            guests: function(Request $request) {
                $fullUrl = $request->fullUrl();
                if($request->is('admin') || $request->is('admin/*')){
                    return;
                }
                return RouteConst::USER->value . "?url=$fullUrl";
            }
        );

        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
