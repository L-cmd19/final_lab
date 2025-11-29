<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth; // Tidak diperlukan lagi untuk redirect

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda publik (Katalog Produk).
     */
    public function index(Request $request)
    {
        // 1. Logika Pencarian
        $query = $request->input('search');
        $productsQuery = Produk::query();

        if ($query) {
            $productsQuery->where('nama_produk', 'like', '%' . $query . '%');
        }

        // 2. Tampilkan 12 produk secara acak/terbaru
        $products = $productsQuery->inRandomOrder()
                                   ->limit(12)
                                   ->with(['store', 'category']) 
                                   ->get();

        // 3. HAPUS LOGIKA REDIRECT (PENTING!)
        // Kita ingin Admin & Seller tetap bisa melihat halaman ini.
        // Tombol navigasi ke dashboard mereka sudah tersedia di Navbar.
        
        // 4. Return View
        return view('welcome', compact('products'));
    }
}