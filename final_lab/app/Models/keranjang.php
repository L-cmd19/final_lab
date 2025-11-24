<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    // Definisikan nama tabel yang digunakan (karena tidak mengikuti konvensi 'carts')
    protected $table = 'keranjangs'; 

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'user_id', 
        'produk_id', 
        'jumlah'
    ];

    // =================================================================
    // RELATIONS (HUBUNGAN)
    // =================================================================

    /**
     * Hubungan M:1. Cart item dimiliki oleh satu User (Buyer).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Hubungan M:1. Cart item merujuk pada satu Product.
     * Foreign key yang digunakan: 'produk_id'
     */
    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}