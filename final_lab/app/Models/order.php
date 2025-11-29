<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'total_harga',
        'status'
    ];
    
    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    
    // PERBAIKAN: Ubah menjadi hasMany karena 1 order bisa banyak review (per produk)
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    public function getTotalQuantity(): int
    {
        return $this->items()->sum('jumlah');
    }
}