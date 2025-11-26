@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <h1 class="text-4xl font-bold mb-8 p5-font text-red-600">ADMIN PHANTOM COMMAND</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-black text-white p-6 shadow-xl border-l-4 border-red-600 relative overflow-hidden group">
            <h3 class="uppercase text-xs font-bold text-gray-400 mb-1">Total Pengguna</h3>
            <div class="text-4xl font-bold mb-2 group-hover:scale-110 transition">User</div>
            <a href="{{ route('admin.users.index') }}" class="text-red-500 font-bold text-sm hover:underline">Kelola User &rarr;</a>
            <div class="absolute -right-4 -bottom-4 text-8xl text-gray-800 opacity-20 p5-font">U</div>
        </div>

        <div class="bg-white p-6 shadow-xl border-t-4 border-black relative overflow-hidden group">
            <h3 class="uppercase text-xs font-bold text-gray-500 mb-1">Kategori Produk</h3>
            <div class="text-4xl font-bold mb-2 text-black group-hover:text-red-600 transition">List</div>
            <a href="{{ route('admin.categories.index') }}" class="text-black font-bold text-sm hover:underline">Kelola Kategori &rarr;</a>
        </div>

        <div class="bg-white p-6 shadow-xl border-t-4 border-yellow-500 relative overflow-hidden">
            <h3 class="uppercase text-xs font-bold text-gray-500 mb-1">Verifikasi Seller</h3>
            <div class="text-4xl font-bold mb-2 text-yellow-600">Pending</div>
            <a href="{{ route('admin.verification.index') }}" class="text-black font-bold text-sm hover:underline">Cek Pengajuan &rarr;</a>
        </div>

        <div class="bg-red-600 text-white p-6 shadow-xl relative overflow-hidden">
            <h3 class="uppercase text-xs font-bold text-red-200 mb-1">Moderasi Produk</h3>
            <div class="text-4xl font-bold mb-2">Safe</div>
            <a href="{{ route('admin.moderation.products.index') }}" class="text-white font-bold text-sm underline">Lihat Semua Produk &rarr;</a>
        </div>
    </div>

    <div class="bg-white p-8 border border-gray-200 shadow-lg">
        <h2 class="text-2xl font-bold mb-4">Aktivitas Terbaru</h2>
        <p class="text-gray-500 italic">Belum ada log aktivitas sistem.</p>
    </div>
</div>
@endsection