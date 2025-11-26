<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk lengkap (Product List Page).
     * Dapat dilengkapi dengan pencarian, filter, dan sorting (Optional).
     */
    public function index(Request $request)
    {
        // Mendapatkan query dari Model Product dengan eager loading relasi yang dibutuhkan
        $productsQuery = Produk::with(['store', 'category']);

        // --- 1. Logika Pencarian (Search) ---
        if ($request->has('search')) {
            $productsQuery->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        // --- 2. Logika Filter Berdasarkan Kategori (Optional Requirement) ---
        if ($request->has('category_id')) {
            $productsQuery->where('kategori_id', $request->category_id);
        }
        
        // --- 3. Logika Sorting (Optional Requirement) ---
        if ($request->has('sort_by') && $request->sort_by == 'price_asc') {
            $productsQuery->orderBy('harga', 'asc');
        } elseif ($request->has('sort_by') && $request->sort_by == 'price_desc') {
            $productsQuery->orderBy('harga', 'desc');
        } else {
            // Default sorting: terbaru
            $productsQuery->latest(); 
        }

        // Ambil data produk dan terapkan pagination (disarankan untuk daftar panjang)
        $products = $productsQuery->paginate(15); 

        // Anda mungkin perlu melempar data kategori ke view untuk filter di sidebar/header
        // $categories = Category::all(); 

        return view('product.list', compact('products'));
    }

    /**
     * Menampilkan detail produk (Product Details Page).
     * Harus menampilkan rating dan review.
     */
    public function show(Produk $product) // Menggunakan Route Model Binding
    {
        // Eager load relasi yang diperlukan: toko, kategori, dan semua review
        $product->load(['store', 'category', 'reviews.user']);

        // Anda juga bisa menghitung rating rata-rata di sini
        $averageRating = $product->reviews->avg('rating');

        return view('product.detail', compact('product', 'averageRating'));
    }
}