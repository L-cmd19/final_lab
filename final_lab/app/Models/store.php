<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    // Nama tabel sudah mengikuti konvensi 'stores'

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'user_id', 
        'nama_toko', 
        'deskripsi', 
        'gamabar' // Perhatikan 'gamabar' (typo dari 'gambar') sesuai migrasi Anda
    ];

    // =================================================================
    // RELATIONS (HUBUNGAN)
    // =================================================================

    /**
     * Hubungan M:1. Store dimiliki oleh satu User (Seller).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Hubungan 1:M. Store memiliki banyak Product.
     * Tabel: 'produks'
     */
    public function products()
    {
        // Foreign key 'store_id' digunakan.
        return $this->hasMany(Produk::class);
    }
    
    // =================================================================
    // HELPER METHODS (FUNGSI BANTUAN)
    // =================================================================

    /**
     * Helper untuk mendapatkan rating rata-rata dari semua produk di toko ini.
     */
    public function averageRating()
    {
        // Menggunakan withAvg untuk menghitung rata-rata rating dari relasi products->reviews
        return $this->products()->withAvg('reviews', 'rating')->pluck('reviews_avg_rating')->avg();
    }
}