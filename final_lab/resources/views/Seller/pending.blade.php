@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-900 flex flex-col justify-center items-center text-white p-4 relative overflow-hidden">
    {{-- Background Hiasan --}}
    <div class="absolute inset-0 bg-red-600 opacity-10 transform -skew-y-12 scale-150"></div>
    
    <div class="relative z-10 bg-black p-10 border-4 border-white shadow-2xl max-w-lg text-center p5-skew">
        <h1 class="text-5xl font-bold mb-4 text-red-600 p5-font transform skew-x-10">TAKE YOUR TIME</h1>
        <h2 class="text-2xl font-bold mb-6">AKUN SEDANG DITINJAU</h2>
        
        <p class="text-gray-300 mb-8 text-lg">
            Permintaan Anda menjadi Seller sedang diproses oleh Admin.<br>
            Silakan cek kembali secara berkala.
        </p>

        <div class="border-t border-gray-700 pt-6">
            <a href="{{ route('home') }}" class="inline-block bg-white text-black font-bold px-6 py-3 hover:bg-red-600 hover:text-white transition duration-300">
                KEMBALI KE HOME
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-400 font-bold underline">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endsection