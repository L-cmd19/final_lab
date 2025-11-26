@extends('layouts.seller')

@section('title', 'Pengaturan Akun Seller')

@section('content')
<div class="max-w-4xl mx-auto">
    
    {{-- Header Kartu Profil --}}
    <div class="bg-white border-l-8 border-black p-8 shadow-md mb-8 flex flex-col md:flex-row items-center md:items-start gap-6">
        {{-- Avatar Inisial --}}
        <div class="bg-black text-white w-20 h-20 flex-shrink-0 flex items-center justify-center text-3xl font-bold rounded-full shadow-lg">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
        
        {{-- Info User --}}
        <div class="text-center md:text-left">
            <h2 class="text-2xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
            <p class="text-gray-500 font-medium">{{ Auth::user()->email }}</p>
            
            <div class="mt-3 flex flex-wrap justify-center md:justify-start gap-2">
                <span class="bg-green-100 text-green-800 px-3 py-1 text-xs font-bold uppercase rounded border border-green-200">
                    Verified Seller
                </span>
                <span class="bg-gray-100 text-gray-600 px-3 py-1 text-xs font-bold uppercase rounded border border-gray-200">
                    Sejak {{ Auth::user()->created_at->format('M Y') }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- 1. FORM EDIT INFORMASI PRIBADI --}}
        <div class="bg-white p-8 shadow-md border-t-4 border-blue-600 h-fit">
            <h3 class="font-bold text-lg mb-6 flex items-center text-gray-800">
                <span class="w-2 h-6 bg-blue-600 mr-3"></span> 
                Edit Informasi Akun
            </h3>
            
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                
                {{-- Nama Lengkap --}}
                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" 
                            class="w-full border-2 border-gray-300 pl-10 p-2 focus:border-blue-600 outline-none transition font-medium" required>
                    </div>
                </div>

                {{-- Email --}}
                <div class="mb-8">
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Email Login</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </span>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" 
                            class="w-full border-2 border-gray-300 pl-10 p-2 focus:border-blue-600 outline-none transition font-medium" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 hover:bg-blue-800 transition shadow-lg transform active:scale-95">
                    SIMPAN PERUBAHAN
                </button>
            </form>
        </div>

        {{-- 2. FORM GANTI PASSWORD --}}
        <div class="bg-white p-8 shadow-md border-t-4 border-red-600 h-fit">
            <h3 class="font-bold text-lg mb-6 flex items-center text-gray-800">
                <span class="w-2 h-6 bg-red-600 mr-3"></span> 
                Ganti Password
            </h3>

            <form action="{{ route('profile.update_password') }}" method="POST">
                @csrf
                
                {{-- Password Lama --}}
                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Password Saat Ini</label>
                    <input type="password" name="current_password" 
                        class="w-full border-2 border-gray-300 p-2 focus:border-red-600 outline-none transition" required>
                    @error('current_password') 
                        <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> 
                    @enderror
                </div>

                {{-- Password Baru --}}
                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Password Baru</label>
                    <input type="password" name="password" 
                        class="w-full border-2 border-gray-300 p-2 focus:border-red-600 outline-none transition" required>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-8">
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-2">Ulangi Password Baru</label>
                    <input type="password" name="password_confirmation" 
                        class="w-full border-2 border-gray-300 p-2 focus:border-red-600 outline-none transition" required>
                </div>

                <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 hover:bg-red-800 transition shadow-lg transform active:scale-95">
                    UPDATE PASSWORD
                </button>
            </form>
        </div>

    </div>
</div>
@endsection