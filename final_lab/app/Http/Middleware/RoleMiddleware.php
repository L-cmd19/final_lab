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
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 2. Cek apakah role user sesuai dengan yang diminta
        // Contoh: jika di route tertulis middleware('role:admin'), maka $role = 'admin'
        if ($user->role !== $role) {
            // Jika role tidak cocok, lempar error 403 (Forbidden)
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
        }

        // 3. Jika cocok, lanjutkan request
        return $next($request);
    }
}