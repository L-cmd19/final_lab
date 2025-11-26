<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// --- PERBAIKAN IMPORT ---
use App\Models\Order;
use App\Models\Produk; // Ditambahkan untuk relasi product()
// -------------------------

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 
        'produk_id',
        'jumlah', 
        'harga_saat_pemesanan'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk_id'); // DIKOREKSI: Menggunakan Model Produk
    }
}