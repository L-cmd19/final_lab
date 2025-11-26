<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// --- PERBAIKAN IMPORT ---
use App\Models\User;
use App\Models\Produk; // Ditambahkan untuk relasi product()
use App\Models\Order;
// -------------------------

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'user_id',
        'order_id',
        'rating',
        'komentar',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk_id'); // DIKOREKSI: Menggunakan Model Produk
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}