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
            // Pastikan kolom ini sesuai dengan database (meskipun typo 'gamabar', harus konsisten)
            'gamabar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $store = $seller->store;
        // Exclude 'gamabar' dari request karena kita proses manual
        $data = $request->except(['_token', 'gamabar']);
        
        if ($request->hasFile('gamabar')) {
            // Hapus gambar lama jika ada
            if ($store && $store->gamabar && Storage::exists('public/stores/' . $store->gamabar)) {
                Storage::delete('public/stores/' . $store->gamabar);
            }
            
            $imagePath = $request->file('gamabar')->store('public/stores');
            $data['gamabar'] = basename($imagePath);
        }

        if ($store) {
            $store->update($data);
            $message = 'Informasi toko berhasil diperbarui!';
        } else {
            // Create Store baru
            $store = Store::create(array_merge($data, [
                'user_id' => $seller->id,
            ]));
            $message = 'Toko berhasil dibuat!';
        }

        return redirect()->route('seller.store.index')->with('success', $message);
    }
}