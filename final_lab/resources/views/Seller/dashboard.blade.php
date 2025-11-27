@extends('layouts.seller')

@section('title', 'Dashboard Seller')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold p5-font text-gray-800">DASHBOARD SELLER</h1>
        <div class="bg-green-100 text-green-800 px-4 py-1 font-bold rounded-full text-sm border border-green-300">
            STATUS: APPROVED
        </div>
    </div>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-black text-white p-6 shadow-lg relative overflow-hidden group border-l-8 border-red-600">
            <div class="relative z-10">
                <h3 class="text-gray-400 text-xs font-bold uppercase mb-1">Toko Anda</h3>
                {{-- PERBAIKAN: Gunakan ?-> --}}
                <div class="text-2xl font-bold mb-4 truncate">
                    {{ Auth::user()->store?->nama_toko ?? 'Belum Diatur' }}
                </div>
                <a href="{{ route('seller.store.index') }}" class="text-red-500 hover:text-white font-bold text-sm underline transition">
                    Kelola Toko &rarr;
                </a>
            </div>
            <div class="absolute right-0 top-0 w-24 h-full bg-gray-800 opacity-20 transform skew-x-12"></div>
        </div>

        <div class="bg-white border border-gray-200 p-6 shadow-lg hover:shadow-xl transition group">
            <h3 class="text-gray-500 text-xs font-bold uppercase mb-1">Total Produk</h3>
            {{-- PERBAIKAN: Gunakan ?-> untuk mencegah crash jika toko belum ada --}}
            <div class="text-4xl font-bold text-red-600 mb-4">
                {{ Auth::user()->store?->products->count() ?? 0 }}
            </div>
            <a href="{{ route('seller.products.create') }}" class="bg-gray-900 text-white px-3 py-1 text-xs font-bold hover:bg-red-600 transition">
                TAMBAH PRODUK
            </a>
        </div>

        <div class="bg-white border border-gray-200 p-6 shadow-lg hover:shadow-xl transition">
            <h3 class="text-gray-500 text-xs font-bold uppercase mb-1">Pesanan Masuk</h3>
            <div class="text-4xl font-bold text-gray-800 mb-4">-</div> 
            <a href="{{ route('seller.orders.index') }}" class="text-blue-600 font-bold text-sm hover:underline">
                Lihat Pesanan &rarr;
            </a>
        </div>
    </div>

    {{-- Akses Cepat --}}
    <h2 class="text-xl font-bold mb-4 border-l-4 border-red-600 pl-4">Akses Cepat</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('seller.products.index') }}" class="block p-4 bg-gray-50 border hover:bg-white hover:border-red-600 transition text-center group">
            <span class="text-3xl mb-2 block group-hover:scale-110 transition">📦</span>
            <span class="font-bold text-gray-700 group-hover:text-red-600">Kelola Produk</span>
        </a>
        <a href="{{ route('seller.orders.index') }}" class="block p-4 bg-gray-50 border hover:bg-white hover:border-red-600 transition text-center group">
            <span class="text-3xl mb-2 block group-hover:scale-110 transition">📄</span>
            <span class="font-bold text-gray-700 group-hover:text-red-600">Pesanan Masuk</span>
        </a>
        <a href="{{ route('seller.store.index') }}" class="block p-4 bg-gray-50 border hover:bg-white hover:border-red-600 transition text-center group">
            <span class="text-3xl mb-2 block group-hover:scale-110 transition">🏪</span>
            <span class="font-bold text-gray-700 group-hover:text-red-600">Info Toko</span>
        </a>
        <a href="{{ route('profile.index') }}" class="block p-4 bg-gray-50 border hover:bg-white hover:border-red-600 transition text-center group">
            <span class="text-3xl mb-2 block group-hover:scale-110 transition">👤</span>
            <span class="font-bold text-gray-700 group-hover:text-red-600">Profil Akun</span>
        </a>
    </div>
</div>
@endsection