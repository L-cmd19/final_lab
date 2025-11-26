@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12 px-4">
    <div class="bg-white p-6 rounded shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Verifikasi Seller (Pending)</h1>
        
        @if($pendingSellers->isEmpty())
            <p class="text-gray-500 italic">Tidak ada pengajuan seller baru saat ini.</p>
        @else
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-4">Nama User</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">Toko</th>
                        <th class="p-4">Tanggal Daftar</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingSellers as $seller)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 font-bold">{{ $seller->name }}</td>
                        <td class="p-4">{{ $seller->email }}</td>
                        <td class="p-4">{{ $seller->store->nama_toko ?? 'Belum dibuat' }}</td>
                        <td class="p-4 text-sm">{{ $seller->created_at->format('d M Y') }}</td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center space-x-2">
                                {{-- Approve --}}
                                <form action="{{ route('admin.verification.update', $seller->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 text-sm font-bold rounded hover:bg-green-600">
                                        APPROVE
                                    </button>
                                </form>
                                {{-- Reject --}}
                                <form action="{{ route('admin.verification.update', $seller->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 text-sm font-bold rounded hover:bg-red-600">
                                        REJECT
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="mt-4">
                {{ $pendingSellers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection