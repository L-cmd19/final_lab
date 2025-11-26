<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk; // Pastikan hanya menggunakan 'Produk'
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminProductModerationController extends Controller
{
    /**
     * Menampilkan daftar semua produk dari semua toko untuk tujuan moderasi.
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if (!$user->isAdmin()) {
                abort(403, 'Akses ditolak.');
            }
        }

        // Gunakan Model 'Produk'
        $productsQuery = Produk::with(['store', 'category'])
                                ->latest();
        
        if ($request->has('search')) {
            $productsQuery->where('nama_produk', 'like', '%' . $request->search . '%')
                          ->orWhereHas('store', function($query) use ($request) {
                              $query->where('nama_toko', 'like', '%' . $request->search . '%');
                          });
        }

        $products = $productsQuery->paginate(15);
        
        return view('admin.moderation.products_index', compact('products'));
    }

    /**
     * Menghapus produk yang melanggar ketentuan.
     */
    public function destroy(Produk $product) // Type hint 'Produk'
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if (!$user->isAdmin()) {
                abort(403, 'Akses ditolak.');
            }
        }

        try {
            if ($product->gambar && Storage::exists('public/products/' . $product->gambar)) {
                Storage::delete('public/products/' . $product->gambar);
            }

            $product->delete();

            return redirect()->route('admin.moderation.products.index')
                             ->with('success', 'Produk "' . $product->nama_produk . '" berhasil dihapus.');
                             
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus produk.');
        }
    }
}