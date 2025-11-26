<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori; // Hanya gunakan 'Kategori'
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCategoryController extends Controller
{
    /**
     * Tampilkan daftar semua kategori.
     */
    public function index()
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if (!$user->isAdmin()) {
                abort(403, 'Akses ditolak.');
            }
        }

        $categories = Kategori::latest()->paginate(10);
        
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Tampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if (!$user->isAdmin()) {
                abort(403, 'Akses ditolak.');
            }
        }

        return view('admin.categories.create');
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if (!$user->isAdmin()) {
                abort(403, 'Akses ditolak.');
            }
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'deskripsi' => 'nullable|string',
        ]);

        // Perbaikan: Gunakan 'Kategori::create'
        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit.
     */
    public function edit(Kategori $category)
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if (!$user->isAdmin()) {
                abort(403, 'Akses ditolak.');
            }
        }

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update kategori.
     */
    public function update(Request $request, Kategori $category)
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if (!$user->isAdmin()) {
                abort(403, 'Akses ditolak.');
            }
        }
        
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $category->id,
            'deskripsi' => 'nullable|string',
        ]);

        $category->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(Kategori $category)
    {
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if (!$user->isAdmin()) {
                abort(403, 'Akses ditolak.');
            }
        }

        if ($category->products()->exists()) {
            return back()->with('error', 'Gagal menghapus kategori. Masih digunakan oleh produk.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}