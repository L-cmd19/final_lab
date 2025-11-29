<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Menerima multiple roles: middleware('role:admin,seller,buyer')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Cek apakah role user ada di dalam daftar yang diizinkan
        if (!in_array($user->role, $roles)) {
            abort(403, 'Akses ditolak. Peran Anda tidak diizinkan.');
        }

        return $next($request);
    }
}