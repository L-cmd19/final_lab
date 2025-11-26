@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="max-w-xl mx-auto bg-white shadow-xl p-8 border-l-8 border-red-600">
        <h1 class="text-2xl font-bold mb-6">EDIT PENGGUNA</h1>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border-2 border-gray-300 p-2 focus:border-red-600 outline-none" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border-2 border-gray-300 p-2 focus:border-red-600 outline-none" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Role</label>
                <select name="role" class="w-full border-2 border-gray-300 p-2 bg-white focus:border-red-600 outline-none">
                    @foreach($roles as $role)
                        <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Status Seller (Hanya muncul/aktif jika role seller, tapi kita tampilkan saja untuk admin) --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Status Seller (Jika Role = Seller)</label>
                <select name="seller_status" class="w-full border-2 border-gray-300 p-2 bg-white focus:border-red-600 outline-none">
                    <option value="">- Bukan Seller -</option>
                    @foreach($sellerStatuses as $status)
                        <option value="{{ $status }}" {{ $user->seller_status == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-black font-bold">Batal</a>
                <button type="submit" class="bg-black text-white px-6 py-2 font-bold hover:bg-red-600 transition p5-skew">SIMPAN PERUBAHAN</button>
            </div>
        </form>
    </div>
</div>
@endsection