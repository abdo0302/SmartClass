<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
        'CheckClassPermission'=>\App\Http\Middleware\CheckClassPermission::class,
        'CheckSinscriPermission'=>\App\Http\Middleware\CheckSinscriPermission::class,
        'CheckSinscriDeletPermission'=>\App\Http\Middleware\CheckSinscriDeletPermission::class,
        'CheckAccesContenuPermission'=>\App\Http\Middleware\CheckAccesContenuPermission::class,
        'CheckShowContenuPermission'=>\App\Http\Middleware\CheckShowContenuPermission::class,
        'CheckShowDevoirPermission'=>\App\Http\Middleware\CheckShowDevoirPermission::class,
        'CheckCreateCorrectionPermission'=>\App\Http\Middleware\CheckCreateCorrectionPermission::class,
        'CheckShowCorrectionDevoirPermission'=>\App\Http\Middleware\CheckShowCorrectionDevoirPermission::class,
        'CheckAccesRoomPermission'=>\App\Http\Middleware\CheckAccesRoomPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
