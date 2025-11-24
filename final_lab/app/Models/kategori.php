<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Definisikan nama tabel yang digunakan (karena tidak mengikuti konvensi 'categories')
    protected $table = 'kategoris';
    
    // Nonaktifkan timestamps karena tabel 'kategoris' tidak memilikinya di migrasi Anda
    public $timestamps = false;

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'nama_kategori', 
        'deskripsi'
    ];

    // =================================================================
    // RELATIONS (HUBUNGAN)
    // =================================================================

    /**
     * Hubungan 1:M. Category memiliki banyak Product.
     * Tabel: 'produks'
     */
    public function products()
    {
        // Pastikan 'Product::class' merujuk ke Model Produk Anda 
        // dan foreign key 'kategori_id' sudah benar.
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}