<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// --- PERBAIKAN IMPORT ---
use App\Models\Produk; // Ditambahkan untuk relasi products()
// -------------------------

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    public $timestamps = false;

    protected $fillable = [
        'nama_kategori', 
        'deskripsi'
    ];

    public function products()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}