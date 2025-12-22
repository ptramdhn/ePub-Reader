<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // --- MULAI TAMBAHAN PENTING ---
        // Memberitahu Laravel untuk mempercayai Load Balancer Railway
        // Ini akan memperbaiki error "Not Secure" saat login dan masalah HTTP vs HTTPS
        $middleware->trustProxies(at: '*');
        // --- SELESAI TAMBAHAN PENTING ---

        // 1. Middleware Global untuk Grup 'Web'
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);

        // 2. Middleware Alias
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();