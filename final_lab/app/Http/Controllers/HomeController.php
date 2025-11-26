<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Logika Pencarian
        $query = $request->input('search');
        $productsQuery = Produk::query();

        if ($query) {
            $productsQuery->where('nama_produk', 'like', '%' . $query . '%');
        }

        // 2. Tampilkan 12 produk
        $products = $productsQuery->inRandomOrder()
                                   ->limit(12)
                                   ->with(['store', 'category']) 
                                   ->get();

        // 3. Logika Redirect (MODIFIKASI DI SINI)
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            
            if ($user) {
                if ($user->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->isApprovedSeller()) {
                    return redirect()->route('seller.dashboard');
                } 
                
                // --- HAPUS ATAU KOMENTARI BAGIAN INI ---
                // elseif ($user->isSeller() && $user->seller_status === 'pending') {
                //    return redirect()->route('seller.pending');
                // }
                // ---------------------------------------
                
                // Dengan menghapus bagian di atas, Seller Pending akan lanjut ke bawah
                // dan melihat tampilan 'welcome' (Katalog Produk).
            }
        }
        
        // 4. Return View
        return view('welcome', compact('products'));
    }
}