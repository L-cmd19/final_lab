@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="flex flex-col md:flex-row gap-8">
        
        {{-- Kolom Kiri: Detail Item --}}
        <div class="md:w-2/3">
            <div class="bg-white shadow-lg p-6 mb-6 border-t-4 border-black">
                <h2 class="text-xl font-bold mb-4">Item Pesanan (Toko Anda)</h2>
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b text-gray-500 text-sm uppercase">
                            <th class="pb-2">Produk</th>
                            <th class="pb-2 text-center">Qty</th>
                            <th class="pb-2 text-right">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            {{-- Filter tampilan hanya produk milik seller yang login --}}
                            @if($item->product->store_id == Auth::user()->store->id)
                            <tr class="border-b last:border-0">
                                <td class="py-3 font-bold">{{ $item->product->nama_produk }}</td>
                                <td class="py-3 text-center">{{ $item->jumlah }}</td>
                                <td class="py-3 text-right">Rp {{ number_format($item->harga_saat_pemesanan, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white shadow p-6">
                <h2 class="text-lg font-bold mb-2">Informasi Pembeli</h2>
                <div class="text-gray-700">
                    <p><strong>Nama:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                    {{-- <p><strong>Alamat:</strong> {{ $order->user->address ?? '-' }}</p> --}}
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Aksi Status --}}
        <div class="md:w-1/3">
            <div class="bg-zinc-50 border border-gray-300 p-6 shadow-xl relative">
                <div class="absolute top-0 right-0 w-10 h-10 bg-red-600"></div>

                <h2 class="text-xl font-bold mb-6">UPDATE STATUS</h2>
                
                <div class="mb-4">
                    <div class="text-xs text-gray-500 uppercase font-bold">Status Saat Ini</div>
                    <div class="text-2xl font-bold uppercase text-red-600">{{ $order->status }}</div>
                </div>

                <form action="{{ route('seller.orders.update_status', $order->id) }}" method="POST">
                    @csrf
                    <label class="block text-sm font-bold mb-2">Ubah Status:</label>
                    <select name="status" class="w-full border-2 border-gray-300 p-2 mb-6 bg-white focus:border-red-600 outline-none">
                        <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>PROCESSED (Sedang Diproses)</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>SHIPPED (Dikirim)</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>COMPLETED (Selesai)</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>CANCELLED (Batal)</option>
                    </select>

                    <button type="submit" class="w-full bg-black text-white font-bold py-3 hover:bg-red-600 transition p5-skew shadow-lg">
                        SIMPAN PERUBAHAN
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection