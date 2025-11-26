<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// --- PERBAIKAN IMPORT ---
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Review;
// -------------------------

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
    
    public function review()
    {
        return $this->hasOne(Review::class);
    }
    
    public function getTotalQuantity(): int
    {
        return $this->items()->sum('jumlah');
    }
}