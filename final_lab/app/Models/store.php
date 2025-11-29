<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Produk;

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
        return $this->hasMany(Produk::class);
    }
    
    // PERBAIKAN: Hitung rata-rata rating dari semua produk di toko ini
    public function averageRating()
    {
        // Ambil rata-rata kolom 'rating' dari tabel reviews yang terhubung lewat produk
        return $this->products()->withAvg('reviews', 'rating')->get()->avg('reviews_avg_rating') ?? 0;
    }
}