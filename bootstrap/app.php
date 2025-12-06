<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
        // ... otros aliases ...
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        // AÑADA ESTA LÍNEA
        'role' => \App\Http\Middleware\CheckRole::class,
        'no_cache' => \App\Http\Middleware\NoCache::class,
        'checkRole' => \App\Http\Middleware\CheckRole::class

    ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
