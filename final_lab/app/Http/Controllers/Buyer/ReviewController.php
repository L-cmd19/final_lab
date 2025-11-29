<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Order $order)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // GANTI: isBuyer() -> canShop()
        if ($order->user_id !== $user->id || !$user->canShop()) {
            abort(403, 'Akses ditolak.');
        }

        if ($order->status !== 'completed') {
            return back()->with('error', 'Review hanya dapat diberikan setelah pesanan Selesai.');
        }

        // Filter item yang belum direview
        $reviewedProductIds = Review::where('order_id', $order->id)->pluck('produk_id')->toArray();
        
        $itemsToReview = $order->items->filter(function($item) use ($reviewedProductIds) {
            return !in_array($item->produk_id, $reviewedProductIds);
        });

        if ($itemsToReview->isEmpty()) {
            return back()->with('warning', 'Semua produk dalam pesanan ini sudah Anda ulas.');
        }

        return view('buyer.review.create', compact('order', 'itemsToReview'));
    }

    public function store(Request $request, Order $order)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($order->user_id !== $user->id || $order->status !== 'completed') {
            abort(403, 'Pesanan tidak valid.');
        }

        $request->validate([
            'produk_id' => 'required|exists:produks,id', 
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        $exists = Review::where('order_id', $order->id)
                        ->where('produk_id', $request->produk_id)
                        ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah mengulas produk ini sebelumnya.');
        }

        Review::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'produk_id' => $request->produk_id, 
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('order.history.show', $order->id)->with('success', 'Ulasan berhasil dikirim!');
    }
}