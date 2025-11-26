<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// --- PERBAIKAN IMPORT ---
use App\Models\Store;
use App\Models\Keranjang; // Diperbaiki dari 'keranjang'
use App\Models\Order;
use App\Models\Review;
// -------------------------

class User extends Authenticatable
{
    // trait HasApiTokens dihapus dari sini
    use HasFactory, Notifiable; 

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'seller_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // =================================================================
    // RELATIONS (HUBUNGAN)
    // =================================================================

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function carts()
    {
        return $this->hasMany(Keranjang::class); // DIKOREKSI
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    // =================================================================
    // HELPER METHODS (FUNGSI BANTUAN)
    // =================================================================

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    public function isApprovedSeller(): bool
    {
        return $this->role === 'seller' && $this->seller_status === 'approved';
    }

    public function isBuyer()
    {
        return $this->role === 'buyer';
    }
}