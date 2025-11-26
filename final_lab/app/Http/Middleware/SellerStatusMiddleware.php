<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SellerStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $status = 'approved'): Response
    {
        // 1. Cek login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 2. Pastikan user adalah seller
        if (!$user->isSeller()) {
            abort(403, 'Halaman ini khusus untuk Seller.');
        }

        // 3. Cek status seller
        if ($user->seller_status !== $status) {
            
            // Jika statusnya masih 'pending', arahkan ke halaman tunggu
            if ($user->seller_status === 'pending') {
                return redirect()->route('seller.pending');
            }

            // Jika status 'rejected', beri pesan error
            if ($user->seller_status === 'rejected') {
                abort(403, 'Akun Seller Anda telah ditolak oleh Admin.');
            }

            abort(403, 'Status akun Seller Anda belum disetujui.');
        }

        return $next($request);
    }
}