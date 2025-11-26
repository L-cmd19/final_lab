@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    {{-- Background Hiasan --}}
    <div class="absolute top-0 right-0 w-full h-full bg-red-600 opacity-10 transform -skew-y-6 origin-bottom-right scale-110"></div>

    <div class="max-w-md w-full space-y-8 relative z-10">
        
        {{-- Header Card --}}
        <div class="bg-black text-white p-6 border-r-8 border-red-600 shadow-2xl transform skew-x-2 text-right">
            <h2 class="mt-2 text-3xl font-extrabold p5-font tracking-widest uppercase">
                Bergabunglah
            </h2>
            <p class="mt-2 text-sm text-gray-400">
                Jadilah bagian dari Phantom Thieves Market.
            </p>
        </div>

        {{-- Form Register --}}
        <div class="bg-white p-8 shadow-2xl border-b-4 border-black relative">
            
            <form class="space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1">NAMA LENGKAP</label>
                    <input id="name" name="name" type="text" required autofocus
                        class="appearance-none rounded-none relative block w-full px-3 py-3 border-2 border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-600 sm:text-sm transition duration-300" 
                        placeholder="Ren Amamiya" value="{{ old('name') }}">
                    @error('name')
                        <span class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1">EMAIL ADDRESS</label>
                    <input id="email" name="email" type="email" required 
                        class="appearance-none rounded-none relative block w-full px-3 py-3 border-2 border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-600 sm:text-sm transition duration-300" 
                        placeholder="joker@phantom.com" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="role" class="block text-sm font-bold text-gray-700 mb-1">DAFTAR SEBAGAI</label>
                    <select id="role" name="role" required
                        class="appearance-none rounded-none relative block w-full px-3 py-3 border-2 border-gray-300 bg-white text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-600 sm:text-sm transition duration-300">
                        <option value="buyer">BUYER (Pembeli)</option>
                        <option value="seller">SELLER (Penjual)</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1 italic">*Akun Seller memerlukan persetujuan Admin.</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-1">PASSWORD</label>
                    <input id="password" name="password" type="password" required 
                        class="appearance-none rounded-none relative block w-full px-3 py-3 border-2 border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-600 sm:text-sm transition duration-300" 
                        placeholder="••••••••">
                    @error('password')
                        <span class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1">KONFIRMASI PASSWORD</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required 
                        class="appearance-none rounded-none relative block w-full px-3 py-3 border-2 border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-600 sm:text-sm transition duration-300" 
                        placeholder="••••••••">
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold text-white bg-red-600 hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300 p5-skew shadow-lg transform hover:-translate-y-1">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-white group-hover:text-red-500 transition" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        DAFTAR SEKARANG
                    </button>
                </div>
            </form>

            {{-- Login Link --}}
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-red-600 hover:text-black underline uppercase">
                        Login di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection