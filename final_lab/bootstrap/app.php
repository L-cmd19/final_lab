<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// --- IMPORT MIDDLEWARE ANDA DI SINI ---
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SellerStatusMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // --- DAFTARKAN ALIAS DI SINI ---
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'status' => SellerStatusMiddleware::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();