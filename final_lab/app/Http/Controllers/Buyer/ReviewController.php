<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use App\Models\Produk; // GUNAKAN PRODUK
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Order $order)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($order->user_id !== $user->id || !$user->isBuyer()) {
            abort(403, 'Akses ditolak.');
        }

        if ($order->status !== 'completed') {
            return back()->with('error', 'Review hanya dapat diberikan setelah pesanan berstatus Selesai.');
        }

        if ($order->review) {
            return back()->with('warning', 'Anda sudah memberikan review untuk pesanan ini.');
        }

        return view('buyer.review.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($order->user_id !== $user->id || $order->status !== 'completed' || $order->review) {
            abort(403, 'Pesanan tidak valid untuk review.');
        }

        $request->validate([
            'produk_id' => 'required|exists:produks,id', 
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        Review::create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'produk_id' => $request->produk_id, 
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('order.history.show', $order)->with('success', 'Review berhasil disimpan.');
    }
}