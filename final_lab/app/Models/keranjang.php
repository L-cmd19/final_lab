<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// --- PERBAIKAN IMPORT ---
use App\Models\User;
use App\Models\Produk; // Ditambahkan untuk relasi product()
// -------------------------

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjangs'; 

    protected $fillable = [
        'user_id', 
        'produk_id', 
        'jumlah'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Produk::class, 'produk_id'); // DIKOREKSI: Menggunakan Model Produk
    }
}