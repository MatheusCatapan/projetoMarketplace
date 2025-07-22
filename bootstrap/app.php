<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use app\Http\Middleware\CheckAdmin;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias(['auth:sanctum' => \App\Http\Middleware\Authenticate::class]);
    })

    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias(['admin' => CheckAdmin::class]);
    })

    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias(['moderador' => \App\Http\Middleware\CheckModerador::class]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
