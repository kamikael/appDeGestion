<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors; // ➜ On importe le middleware CORS

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // ➜ Important : ajoute la route API si elle manque
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function () {
        Middleware::alias([
            'isAdmin' => IsAdmin::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware): void {
        // ➜ Active le CORS globalement
        $middleware->append(HandleCors::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
