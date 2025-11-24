<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Nama tabel sudah mengikuti konvensi 'order_items'
    // Jadi, kita tidak perlu mendefinisikan $table

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'order_id', 
        'produk_id',              // Foreign key ke tabel 'produks'
        'jumlah', 
        'harga_saat_pemesanan'    // Harga produk saat order dibuat
    ];

    // =================================================================
    // RELATIONS (HUBUNGAN)
    // =================================================================

    /**
     * Hubungan M:1. OrderItem adalah bagian dari satu Order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Hubungan M:1. OrderItem merujuk pada satu Product.
     * Menggunakan foreign key 'produk_id'
     */
    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}