@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold p5-font text-gray-800">MANAJEMEN PENGGUNA</h1>
        
        {{-- Form Pencarian --}}
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex w-full md:w-auto">
            <input type="text" name="search" placeholder="Cari nama atau email..." class="border-2 border-gray-300 px-4 py-2 w-full md:w-64 focus:border-red-600 outline-none transition" value="{{ request('search') }}">
            <button type="submit" class="bg-black text-white px-6 py-2 font-bold hover:bg-red-600 transition">CARI</button>
        </form>
    </div>

    <div class="bg-white shadow-lg overflow-hidden border-t-4 border-black">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 border-b-2 border-gray-300 uppercase text-xs font-bold text-gray-600">
                <tr>
                    <th class="p-4">ID</th>
                    <th class="p-4">Nama User</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Role</th>
                    <th class="p-4">Status Seller</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-4 text-gray-500 font-mono text-sm">{{ $user->id }}</td>
                    <td class="p-4 font-bold text-gray-800">{{ $user->name }}</td>
                    <td class="p-4 text-sm">{{ $user->email }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 text-xs font-bold uppercase rounded border
                            {{ $user->role == 'admin' ? 'bg-red-50 text-red-700 border-red-200' : '' }}
                            {{ $user->role == 'seller' ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                            {{ $user->role == 'buyer' ? 'bg-green-50 text-green-700 border-green-200' : '' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="p-4">
                        @if($user->role == 'seller')
                            <span class="text-xs font-bold uppercase {{ $user->seller_status == 'approved' ? 'text-green-600' : ($user->seller_status == 'pending' ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $user->seller_status }}
                            </span>
                        @else
                            <span class="text-gray-300 text-xs">-</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center space-x-2">
                            {{-- Edit --}}
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-gray-100 text-gray-700 hover:bg-blue-600 hover:text-white px-3 py-1 rounded text-xs font-bold transition">
                                Edit
                            </a>
                            
                            {{-- Hapus (Cegah hapus diri sendiri) --}}
                            @if(Auth::id() !== $user->id)
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Menghapus user ini akan menghapus semua data terkait (Toko, Produk, Order). Lanjutkan?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-gray-100 text-gray-700 hover:bg-red-600 hover:text-white px-3 py-1 rounded text-xs font-bold transition">
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500">Data pengguna tidak ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
</div>
@endsection