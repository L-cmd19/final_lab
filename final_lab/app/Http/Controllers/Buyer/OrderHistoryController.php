<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isBuyer()) {
            abort(403, 'Akses ditolak.');
        }

        $orders = Order::where('user_id', $user->id)
                       ->with('items')
                       ->latest()
                       ->paginate(10);

        return view('buyer.order_history.index', compact('orders'));
    }

    public function show(Order $order)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($order->user_id !== $user->id) {
            abort(403, 'Akses ditolak. Pesanan ini bukan milik Anda.');
        }

        // Load relasi. Pastikan 'items.product' mengarah ke model Produk
        $order->load(['items.product.store', 'review']);

        return view('buyer.order_history.show', compact('order'));
    }
}