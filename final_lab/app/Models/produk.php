<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    // Definisikan nama tabel yang digunakan
    protected $table = 'produks';
    
    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'store_id', 
        'kategori_id', 
        'nama_produk', 
        'deskripsi', 
        'harga', 
        'stok', 
        'gambar'
    ];

    // =================================================================
    // RELATIONS (HUBUNGAN)
    // =================================================================

    /**
     * Hubungan M:1. Product dimiliki oleh satu Store.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Hubungan M:1. Product termasuk dalam satu Category.
     */
    public function category()
    {
        // Foreign key 'kategori_id' digunakan sesuai dengan nama kolom di tabel 'produks'
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Hubungan 1:M. Product memiliki banyak Review.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    /**
     * Hubungan 1:M. Product dapat ada di banyak Cart (keranjang).
     */
    public function carts()
    {
        return $this->hasMany(Keranjang::class);
    }
}