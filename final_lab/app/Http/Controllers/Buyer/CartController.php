<?php

namespace App\Http\Controllers;

use App\Models\Keranjang; // Huruf Besar K
use App\Models\Produk;    // Huruf Besar P, Bahasa Indonesia
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isBuyer()) {
            abort(403, 'Akses ditolak.');
        }

        $cartItems = Keranjang::where('user_id', $user->id)
                         ->with('product') // Pastikan relasi di Model Keranjang bernama 'product'
                         ->get();

        $subtotal = $cartItems->sum(function($item) {
            // Asumsi relasi di Keranjang adalah 'product' yang mengarah ke model Produk
            return $item->jumlah * $item->product->harga;
        });

        return view('buyer.cart.index', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user || !$user->isBuyer()) {
            return redirect()->route('login')->with('warning', 'Anda harus login sebagai Buyer.');
        }

        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Produk::find($request->produk_id);
        $quantity = $request->quantity;

        if ($quantity > $product->stok) {
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $cartItem = Keranjang::where('user_id', $user->id)
                        ->where('produk_id', $product->id)
                        ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->jumlah + $quantity;
            if ($newQuantity > $product->stok) {
                 return back()->with('error', 'Penambahan melebihi stok.');
            }
            $cartItem->update(['jumlah' => $newQuantity]);
            $message = 'Jumlah produk diperbarui.';
        } else {
            Keranjang::create([
                'user_id' => $user->id,
                'produk_id' => $product->id,
                'jumlah' => $quantity,
            ]);
            $message = 'Produk ditambahkan ke keranjang!';
        }

        return back()->with('success', $message);
    }

    public function update(Request $request, Keranjang $cart)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($cart->user_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);
        
        $newQuantity = $request->jumlah;
        $product = $cart->product;

        if ($newQuantity > $product->stok) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart->update(['jumlah' => $newQuantity]);

        return back()->with('success', 'Jumlah diperbarui.');
    }

    public function destroy(Keranjang $cart)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($cart->user_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $cart->delete();

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}