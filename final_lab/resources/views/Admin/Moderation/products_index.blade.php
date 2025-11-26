@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <h1 class="text-2xl font-bold mb-6 text-red-600 uppercase">Moderasi Produk (Global)</h1>
    
    {{-- Form Search --}}
    <form action="{{ route('admin.moderation.products.index') }}" method="GET" class="mb-6 flex max-w-lg">
        <input type="text" name="search" placeholder="Cari produk / nama toko..." class="flex-1 border-2 border-gray-300 p-2 outline-none focus:border-red-600" value="{{ request('search') }}">
        <button type="submit" class="bg-black text-white px-4 font-bold">CARI</button>
    </form>

    <div class="bg-white shadow border border-gray-200">
        <table class="w-full text-left">
            <thead class="bg-gray-800 text-white uppercase text-xs">
                <tr>
                    <th class="p-3">Produk</th>
                    <th class="p-3">Toko (Seller)</th>
                    <th class="p-3">Harga</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3 flex items-center">
                        <img src="{{ asset('storage/products/' . $product->gambar) }}" class="w-10 h-10 object-cover mr-3 border">
                        <span class="font-bold text-sm">{{ $product->nama_produk }}</span>
                    </td>
                    <td class="p-3 text-sm">
                        {{ $product->store->nama_toko ?? 'Unknown' }}
                    </td>
                    <td class="p-3 text-sm font-bold">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </td>
                    <td class="p-3 text-center">
                        {{-- Tombol Hapus Paksa (Moderasi) --}}
                        <form action="{{ route('admin.moderation.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Anda akan menghapus produk milik pengguna lain. Lanjutkan?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white text-xs px-3 py-1 font-bold rounded hover:bg-red-800">
                                TAKE DOWN
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection