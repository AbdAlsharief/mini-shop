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

    // ── Relationships ─────────────────────────────────────────

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    // ── Role helpers ─────────────────────────────────────────

    /**
     * Check if user has any of the given role names (OR logic).
     * master satisfies ALL role checks (hierarchy).
     *
     * Role names: master, admin, merchant, customer
     * Used by CheckRole middleware: ->middleware('role:merchant')
     */
    public function hasRole(array|string $roles): bool
    {
        $roles = (array) $roles;

        $userRoles = $this->roles->pluck('name')->toArray();

        // master passes everything
        if (in_array('master', $userRoles)) {
            return true;
        }

        return (bool) array_intersect($userRoles, $roles);
    }

    /** True for merchant + master (can manage products) */
    public function isMerchant(): bool
    {
        return $this->hasRole(['merchant', 'master']);
    }

    /** True for admin + master (can manage merchants) */
    public function isAdminRole(): bool
    {
        return $this->hasRole(['admin', 'master']);
    }

    /** Only master */
    public function isMasterAdmin(): bool
    {
        return $this->roles->contains('name', 'master');
    }

    public function isClient(): bool
    {
        return !$this->isMerchant() && !$this->isAdminRole();
    }
}
