<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Nama tabel adalah 'orders', sesuai konvensi dan migrasi Anda

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'user_id', 
        'total_harga', // Menggunakan nama kolom dari migrasi Anda
        'status'
    ];
    
    // Casting agar 'status' otomatis menjadi tipe enum/string saat diakses
    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }

    // =================================================================
    // RELATIONS (HUBUNGAN)
    // =================================================================

    /**
     * Hubungan M:1. Order dimiliki oleh satu User (Buyer).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Hubungan 1:M. Order memiliki banyak OrderItem (item/detail barang dalam pesanan).
     * Tabel: 'order_items'
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    /**
     * Hubungan 1:1. Order dapat memiliki satu Review (setelah pesanan selesai).
     * Relasi ini akan sangat penting untuk implementasi fitur Rating & Review.
     * Tabel: 'reviews'
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // =================================================================
    // HELPER METHODS (FUNGSI BANTUAN)
    // =================================================================
    
    /**
     * Helper untuk menghitung total item dalam pesanan ini.
     */
    public function getTotalQuantity(): int
    {
        return $this->items()->sum('jumlah');
    }
}