<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori; // Pastikan pakai Model Kategori Anda

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        Kategori::create(['nama_kategori' => 'Elektronik', 'deskripsi' => 'Gadget dan alat listrik']);
        Kategori::create(['nama_kategori' => 'Pakaian Pria', 'deskripsi' => 'Fashion pria terkini']);
        Kategori::create(['nama_kategori' => 'Pakaian Wanita', 'deskripsi' => 'Fashion wanita terkini']);
        Kategori::create(['nama_kategori' => 'Makanan & Minuman', 'deskripsi' => 'Snack dan minuman']);
        Kategori::create(['nama_kategori' => 'Hobi & Mainan', 'deskripsi' => 'Action figure dan hobi']);
        Kategori::create(['nama_kategori' => 'Game', 'deskripsi' => 'Permainan dan video game']);
    }


}