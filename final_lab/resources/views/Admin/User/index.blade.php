@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold p5-font">MANAJEMEN PENGGUNA</h1>
        
        {{-- Form Pencarian User --}}
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex">
            <input type="text" name="search" placeholder="Cari nama/email..." class="border border-gray-400 px-3 py-1 text-sm outline-none focus:border-red-600" value="{{ request('search') }}">
            <button type="submit" class="bg-black text-white px-4 py-1 text-sm font-bold hover:bg-red-600">CARI</button>
        </form>
    </div>

    <div class="bg-white shadow border-t-4 border-black overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100 border-b uppercase text-xs font-bold text-gray-600">
                    <th class="p-4">ID</th>
                    <th class="p-4">Nama</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Role</th>
                    <th class="p-4">Status Seller</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-4">{{ $user->id }}</td>
                    <td class="p-4 font-bold">{{ $user->name }}</td>
                    <td class="p-4 text-sm">{{ $user->email }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 text-xs font-bold uppercase rounded
                            {{ $user->role == 'admin' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $user->role == 'seller' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $user->role == 'buyer' ? 'bg-green-100 text-green-800' : '' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="p-4">
                        @if($user->role == 'seller')
                            <span class="text-xs font-bold uppercase {{ $user->seller_status == 'approved' ? 'text-green-600' : 'text-gray-500' }}">
                                {{ $user->seller_status }}
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:underline text-sm font-bold">Edit</a>
                            
                            @if(Auth::id() !== $user->id)
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini selamanya? Data terkait akan hilang.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm font-bold">Hapus</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection