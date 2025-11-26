@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="max-w-4xl mx-auto flex flex-col md:flex-row gap-8">
        
        {{-- Kartu Profil --}}
        <div class="md:w-1/3">
            <div class="bg-white shadow-lg p-6 text-center border-t-8 border-black">
                <div class="w-24 h-24 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center text-4xl">👤</div>
                <h2 class="text-xl font-bold">{{ $user->name }}</h2>
                <div class="text-gray-500 mb-4">{{ $user->email }}</div>
                <span class="px-3 py-1 bg-gray-100 text-xs font-bold uppercase rounded">{{ $user->role }}</span>
            </div>
        </div>

        {{-- Form Edit --}}
        <div class="md:w-2/3">
            {{-- Edit Info Dasar --}}
            <div class="bg-white shadow p-6 mb-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Edit Informasi</h3>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border p-2 rounded">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border p-2 rounded">
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 font-bold text-sm hover:bg-blue-700">Simpan Profil</button>
                </form>
            </div>

            {{-- Ganti Password --}}
            <div class="bg-white shadow p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2 text-red-600">Ganti Password</h3>
                <form action="{{ route('profile.update_password') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-1">Password Lama</label>
                        <input type="password" name="current_password" class="w-full border p-2 rounded" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-bold mb-1">Password Baru</label>
                            <input type="password" name="password" class="w-full border p-2 rounded" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
                        </div>
                    </div>
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 font-bold text-sm hover:bg-red-700">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection