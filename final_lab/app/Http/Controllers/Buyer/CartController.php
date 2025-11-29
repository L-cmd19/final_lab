<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // GANTI: isBuyer() -> canShop()
        if (!$user->canShop()) {
            abort(403, 'Akses ditolak.');
        }

        $cartItems = Keranjang::where('user_id', $user->id)->with('product')->get();
        $subtotal = $cartItems->sum(fn($item) => $item->jumlah * $item->product->harga);

        return view('buyer.cart.index', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // GANTI: isBuyer() -> canShop()
        if (!$user || !$user->canShop()) {
            return redirect()->route('login')->with('warning', 'Silakan login untuk berbelanja.');
        }

        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Produk::find($request->produk_id);
        
        if ($request->quantity > $product->stok) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $cartItem = Keranjang::where('user_id', $user->id)
                        ->where('produk_id', $product->id)
                        ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->jumlah + $request->quantity;
            if ($newQuantity > $product->stok) {
                 return back()->with('error', 'Penambahan melebihi stok.');
            }
            $cartItem->update(['jumlah' => $newQuantity]);
        } else {
            Keranjang::create([
                'user_id' => $user->id,
                'produk_id' => $product->id,
                'jumlah' => $request->quantity,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Keranjang $cart)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($cart->user_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate(['jumlah' => 'required|integer|min:1']);
        
        if ($request->jumlah > $cart->product->stok) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart->update(['jumlah' => $request->jumlah]);

        return back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function destroy(Keranjang $cart)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($cart->user_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $cart->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}