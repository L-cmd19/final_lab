<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Import Middleware Anda
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\SellerStatusMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // 1. Alias Middleware Anda
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'status' => SellerStatusMiddleware::class,
        ]);

        // 2. TAMBAHKAN INI: Mengatur Redirect Default
        // Ini menggantikan fungsi file RedirectIfAuthenticated.php yang hilang
        $middleware->redirectTo(
            guests: '/login', // Jika belum login, lempar ke login
            users: '/'        // Jika SUDAH login, lempar ke '/' (Home), BUKAN '/dashboard'
        );
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();