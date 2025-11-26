<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda publik (Homepage) dengan daftar produk.
     */
    public function index(Request $request)
    {
        // 1. Logika untuk Pencarian
        $query = $request->input('search');
        
        $productsQuery = Produk::query();

        if ($query) {
            $productsQuery->where('nama_produk', 'like', '%' . $query . '%');
        }

        // 2. Tampilkan 12 produk dengan relasi
        $products = $productsQuery->inRandomOrder()
                                   ->limit(12)
                                   ->with(['store', 'category']) 
                                   ->get();

        // 3. Logika Redirect Berdasarkan Role
        if (Auth::check()) {
            /** @var \App\Models\User $user */ // Memberitahu editor bahwa ini Model User kita
            $user = Auth::user();
            
            // Cek apakah user null (safety check)
            if ($user) {
                if ($user->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                } elseif ($user->isApprovedSeller()) {
                    return redirect()->route('seller.dashboard');
                } elseif ($user->isSeller() && $user->seller_status === 'pending') {
                    return redirect()->route('seller.pending');
                }
            }
        }
        
        // 4. Return View
        return view('welcome', compact('products'));
    }
}