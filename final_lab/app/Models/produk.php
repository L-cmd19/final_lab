<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// --- PERBAIKAN IMPORT ---
use App\Models\Store;
use App\Models\Kategori;
use App\Models\Review;
use App\Models\Keranjang; // Ditambahkan untuk relasi carts()
// -------------------------

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';
    
    protected $fillable = [
        'store_id', 
        'kategori_id', 
        'nama_produk', 
        'deskripsi', 
        'harga', 
        'stok', 
        'gambar'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id'); // DIKOREKSI: Menggunakan Model Kategori
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    public function carts()
    {
        return $this->hasMany(Keranjang::class); // DIKOREKSI: Menggunakan Model Keranjang
    }
}