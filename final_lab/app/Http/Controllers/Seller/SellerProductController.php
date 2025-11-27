<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerProductController extends Controller
{
    /**
     * Menampilkan daftar produk.
     */
    public function index()
    {
        /** @var \App\Models\User $seller */
        $seller = Auth::user();

        if (!$seller->isApprovedSeller() || !$seller->store) {
            abort(403, 'Akses ditolak. Anda tidak memiliki toko atau belum disetujui.');
        }

        $products = Produk::where('store_id', $seller->store->id)
                           ->with('category')
                           ->latest()
                           ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    /**
     * Menampilkan form tambah produk.
     */
    public function create()
    {
        /** @var \App\Models\User $seller */
        $seller = Auth::user();

        if (!$seller->isApprovedSeller() || !$seller->store) {
            abort(403, 'Akses ditolak.');
        }

        // Ambil semua data kategori untuk dropdown
        $categories = Kategori::all(); 

        return view('seller.products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru.
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $seller */
        $seller = Auth::user();

        if (!$seller->isApprovedSeller() || !$seller->store) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan gambar ke disk 'public' di folder 'products'
        $imagePath = $request->file('gambar')->store('products', 'public');
        $imageName = basename($imagePath);

        Produk::create([
            'store_id' => $seller->store->id,
            'kategori_id' => $request->kategori_id,
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $imageName,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit(Produk $product)
    {
        /** @var \App\Models\User $seller */
        $seller = Auth::user();
        
        // Cek kepemilikan produk
        if (!$seller->isApprovedSeller() || !$seller->store || $product->store_id !== $seller->store->id) {
            abort(403, 'Anda tidak berhak mengedit produk ini.');
        }

        $categories = Kategori::all();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    /**
     * Mengupdate produk.
     */
    public function update(Request $request, Produk $product)
    {
        /** @var \App\Models\User $seller */
        $seller = Auth::user();
        
        if (!$seller->isApprovedSeller() || !$seller->store || $product->store_id !== $seller->store->id) {
            abort(403, 'Anda tidak berhak memperbarui produk ini.');
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = $request->except(['_token', '_method', 'gambar']);
        
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($product->gambar && Storage::disk('public')->exists('products/' . $product->gambar)) {
                Storage::disk('public')->delete('products/' . $product->gambar);
            }
            
            // PERBAIKAN DI SINI: Gunakan format yang sama dengan store()
            // Jangan pakai 'public/products', tapi 'products', 'public'
            $imagePath = $request->file('gambar')->store('products', 'public');
            $data['gambar'] = basename($imagePath);
        }

        $product->update($data);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk.
     */
    public function destroy(Produk $product)
    {
        /** @var \App\Models\User $seller */
        $seller = Auth::user();

        if (!$seller->isApprovedSeller() || !$seller->store || $product->store_id !== $seller->store->id) {
            abort(403, 'Anda tidak berhak menghapus produk ini.');
        }

        try {
            // Hapus gambar fisik
            if ($product->gambar && Storage::disk('public')->exists('products/' . $product->gambar)) {
                Storage::disk('public')->delete('products/' . $product->gambar);
            }

            $product->delete();

            return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('seller.products.index')->with('error', 'Gagal menghapus produk.');
        }
    }
}