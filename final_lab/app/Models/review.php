<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // Nama tabel sudah mengikuti konvensi 'reviews'

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'produk_id',    // Foreign key ke tabel 'produks'
        'user_id',      // Foreign key ke tabel 'users'
        'order_id',     // Penting: Foreign key ke tabel 'orders'
        'rating',
        'komentar',     // Menggunakan nama kolom dari migrasi Anda
    ];

    // Casting agar 'rating' menjadi integer
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    // =================================================================
    // RELATIONS (HUBUNGAN)
    // =================================================================

    /**
     * Hubungan M:1. Review diberikan oleh satu User (Buyer).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Hubungan M:1. Review merujuk pada satu Product.
     * Foreign key yang digunakan: 'produk_id'
     */
    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
    
    /**
     * Hubungan M:1. Review terkait dengan satu Order tertentu.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}