<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// --- PERBAIKAN IMPORT ---
use App\Models\User;
use App\Models\Produk; // Ditambahkan untuk relasi products()
// -------------------------

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'nama_toko', 
        'deskripsi', 
        'gamabar' 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Produk::class); // DIKOREKSI: Menggunakan Model Produk
    }
    
    public function averageRating()
    {
        // Menggunakan withAvg untuk menghitung rata-rata rating dari relasi products->reviews
        return $this->products()->withAvg('reviews', 'rating')->pluck('reviews_avg_rating')->avg();
    }
}