<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Import Model Relasi
use App\Models\Store;
use App\Models\Keranjang;
use App\Models\Order;
use App\Models\Review;

class User extends Authenticatable
{
    use HasFactory, Notifiable; 

    protected $fillable = [
        'name', 'email', 'password', 'role', 'seller_status',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // RELASI
    public function store() { return $this->hasOne(Store::class); }
    public function carts() { return $this->hasMany(Keranjang::class); }
    public function orders() { return $this->hasMany(Order::class); }
    public function reviews() { return $this->hasMany(Review::class); }

    // HELPER METHODS
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isSeller(): bool { return $this->role === 'seller'; }
    public function isBuyer(): bool { return $this->role === 'buyer'; }
    
    public function isApprovedSeller(): bool {
        return $this->role === 'seller' && $this->seller_status === 'approved';
    }

    // --- PERBAIKAN: Fungsi Baru canShop() ---
    public function canShop(): bool
    {
        // Semua role (Admin, Seller, Buyer) boleh belanja
        return in_array($this->role, ['admin', 'seller', 'buyer']);
    }
}