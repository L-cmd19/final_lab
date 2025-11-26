<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SellerProductController extends Controller
{
    /**
     * Menampilkan daftar pesanan yang masuk khusus untuk produk-produk di toko Seller.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $seller */
        $seller = Auth::user();
        
        // 1. Otorisasi
        if (!$seller->isApprovedSeller() || !$seller->store) {
            abort(403, 'Akses ditolak. Anda bukan Seller yang disetujui atau belum memiliki toko.');
        }

        // 2. Dapatkan ID produk milik toko seller
        $productIds = $seller->store->products->pluck('id');

        // 3. Cari Order yang mengandung produk-produk tersebut
        $incomingOrders = Order::whereHas('items', function ($query) use ($productIds) {
            $query->whereIn('produk_id', $productIds);
        })
        ->with(['user', 'items.product']) 
        ->latest()
        ->paginate(15);

        return view('seller.orders.index', compact('incomingOrders'));
    }

    public function show(Order $order)
    {
        /** @var \App\Models\User $seller */
        $seller = Auth::user();

        if (!$seller->isApprovedSeller() || !$seller->store) {
            abort(403, 'Akses ditolak.');
        }

        // Dapatkan ID produk milik Seller
        $sellerProductIds = $seller->store->products->pluck('id')->toArray();

        // Cek apakah di dalam order ini ada barang milik seller
        $hasSellerProduct = $order->items->contains(function ($item) use ($sellerProductIds) {
            return in_array($item->produk_id, $sellerProductIds); 
        });

        if (!$hasSellerProduct) {
            abort(403, 'Akses ditolak. Pesanan ini tidak terkait dengan toko Anda.');
        }
        
        // Load relasi
        $order->load('user', 'items.product.store');

        return view('seller.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        /** @var \App\Models\User $seller */
        $seller = Auth::user();

        if (!$seller->isApprovedSeller() || !$seller->store) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $sellerProductIds = $seller->store->products->pluck('id')->toArray();

        // Verifikasi Kepemilikan
        $hasSellerProduct = $order->items->contains(function ($item) use ($sellerProductIds) {
            return in_array($item->produk_id, $sellerProductIds);
        });

        if (!$hasSellerProduct) {
            return response()->json(['message' => 'Pesanan tidak terkait dengan toko Anda'], 403);
        }

        // Validasi
        $request->validate([
            'status' => ['required', 'string', Rule::in(['processed', 'shipped', 'completed', 'cancelled'])],
        ]);

        // Update
        $order->status = $request->status;
        $order->save();

        return redirect()->route('seller.orders.index')->with('success', 'Status pesanan berhasil diperbarui menjadi ' . $request->status . '.');
    }
}