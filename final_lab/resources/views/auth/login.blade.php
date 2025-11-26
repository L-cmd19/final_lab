@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    {{-- Background Hiasan --}}
    <div class="absolute top-0 left-0 w-full h-full bg-red-600 opacity-10 transform skew-y-6 origin-top-left scale-110"></div>

    <div class="max-w-md w-full space-y-8 relative z-10">
        
        {{-- Header Card --}}
        <div class="bg-black text-white p-6 border-l-8 border-red-600 shadow-2xl transform -skew-x-2">
            <h2 class="mt-2 text-center text-3xl font-extrabold p5-font tracking-widest">
                PHANTOM LOGIN
            </h2>
            <p class="mt-2 text-center text-sm text-gray-400">
                Masuk untuk mengakses Shadow World... atau Toko.
            </p>
        </div>

        {{-- Form Login --}}
        <div class="bg-white p-8 shadow-2xl border-t-4 border-black relative">
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-1">EMAIL ADDRESS</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                        class="appearance-none rounded-none relative block w-full px-3 py-3 border-2 border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-600 focus:z-10 sm:text-sm transition duration-300" 
                        placeholder="joker@phantom.com" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-1">PASSWORD</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required 
                        class="appearance-none rounded-none relative block w-full px-3 py-3 border-2 border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-red-500 focus:border-red-600 focus:z-10 sm:text-sm transition duration-300" 
                        placeholder="••••••••">
                    @error('password')
                        <span class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900 font-bold">
                            Ingat Saya
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-medium text-red-600 hover:text-red-500 hover:underline">
                                Lupa password?
                            </a>
                        </div>
                    @endif
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold text-white bg-black hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300 p5-skew shadow-lg">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-red-500 group-hover:text-white transition" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        MASUK (LOGIN)
                    </button>
                </div>
            </form>

            {{-- Register Link --}}
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="font-bold text-black hover:text-red-600 underline">
                        Daftar sebagai Buyer atau Seller
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection