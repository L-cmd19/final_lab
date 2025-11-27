<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $seller */
        $seller = Auth::user();

        // 1. Otorisasi dasar
        if (!$seller->isSeller()) {
            abort(403, 'Akses ditolak. Anda bukan Seller.');
        }

        // 2. Cek status persetujuan
        if ($seller->seller_status !== 'approved') {
            return redirect()->route('seller.pending')->with('warning', 'Toko Anda belum disetujui Admin.');
        }
        
        // Ambil data toko (bisa null jika belum dibuat)
        $store = $seller->store;

        return view('seller.store.index', compact('store'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $seller */
        $seller = Auth::user();

        if (!$seller->isApprovedSeller()) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            // Pastikan validasi gambar aman (nullable)
            'gamabar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        // Ambil toko yang sudah ada
        $store = $seller->store;
        
        // Exclude 'gamabar' dari request karena kita proses manual
        $data = $request->except(['_token', 'gamabar']);
        
        if ($request->hasFile('gamabar')) {
            // Hapus gambar lama jika toko sudah ada dan punya gambar
            // PERBAIKAN: Gunakan disk 'public' dan path 'stores/' (bukan public/stores/)
            if ($store && $store->gamabar && Storage::disk('public')->exists('stores/' . $store->gamabar)) {
                Storage::disk('public')->delete('stores/' . $store->gamabar);
            }
            
            // PERBAIKAN: Simpan ke folder 'stores' di disk 'public'
            $imagePath = $request->file('gamabar')->store('stores', 'public');
            $data['gamabar'] = basename($imagePath);
        }

        if ($store) {
            // Jika toko sudah ada, Update
            $store->update($data);
            $message = 'Informasi toko berhasil diperbarui!';
        } else {
            // Jika toko belum ada, Create baru
            Store::create(array_merge($data, [
                'user_id' => $seller->id,
            ]));
            $message = 'Toko berhasil dibuat!';
        }

        return redirect()->route('seller.store.index')->with('success', $message);
    }
}