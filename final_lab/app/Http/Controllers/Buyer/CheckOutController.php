<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;    // GUNAKAN PRODUK
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Menggunakan relasi 'carts' dari User Model
        $cartItems = $user->carts()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->jumlah * $item->product->harga;
        });
        
        return view('buyer.checkout.index', compact('cartItems', 'subtotal'));
    }

    public function process(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        DB::beginTransaction();

        try {
            $cartItems = $user->carts()->with('product')->get();
            $totalAmount = 0;
            $orderItemsData = [];

            foreach ($cartItems as $item) {
                $product = $item->product;

                if ($item->jumlah > $product->stok) {
                    DB::rollBack();
                    return redirect()->route('cart.index')->with('error', 'Stok ' . $product->nama_produk . ' tidak mencukupi.');
                }

                $orderItemsData[] = [
                    'produk_id' => $product->id,
                    'jumlah' => $item->jumlah,
                    'harga_saat_pemesanan' => $product->harga,
                ];

                $totalAmount += $item->jumlah * $product->harga;
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total_harga' => $totalAmount,
                'status' => 'pending',
            ]);

            foreach ($orderItemsData as $data) {
                $data['order_id'] = $order->id;
                OrderItem::create($data);

                // Perbaikan: Gunakan Model 'Produk'
                Produk::where('id', $data['produk_id'])->decrement('stok', $data['jumlah']);
            }
            
            // Hapus isi keranjang via relasi
            $user->carts()->delete();

            DB::commit();

            return redirect()->route('order.history.index')->with('success', 'Pesanan Anda berhasil dibuat! Menunggu pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Gagal memproses pesanan: ' . $e->getMessage());
        }
    }
}