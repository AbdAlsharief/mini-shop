<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ── Role helpers ─────────────────────────────────────────

    /** Merchant AND master_admin can manage products */
    public function isMerchant(): bool
    {
        return in_array($this->role, ['merchant', 'master_admin']);
    }

    /** Admin AND master_admin can manage merchants */
    public function isAdminRole(): bool
    {
        return in_array($this->role, ['admin', 'master_admin']);
    }

    /** Only master_admin can manage admins and other masters */
    public function isMasterAdmin(): bool
    {
        return $this->role === 'master_admin';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    // ── Relationships ─────────────────────────────────────────

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }
}
