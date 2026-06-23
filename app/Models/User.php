<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * Attributs assignables en masse.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'is_active',
        'two_factor_enabled',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    /**
     * Attributs cachés lors de la sérialisation (jamais exposés en JSON/API).
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    /**
     * Casts automatiques.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'     => 'datetime',
            'password'              => 'hashed',
            'is_active'             => 'boolean',
            'two_factor_enabled'    => 'boolean',
            'two_factor_expires_at' => 'datetime',
        ];
    }

    // ------------------------------------------------------
    // Relations
    // ------------------------------------------------------

    /**
     * Demandes de crédit faites par ce client.
     */
    public function loanApplications()
    {
        return $this->hasMany(LoanApplication::class, 'user_id');
    }

    /**
     * Dossiers que cet agent a instruits / validés.
     */
    public function handledLoanApplications()
    {
        return $this->hasMany(LoanApplication::class, 'agent_id');
    }

    /**
     * Remboursements effectués par ce client.
     */
    public function repayments()
    {
        return $this->hasMany(Repayment::class, 'user_id');
    }

    // ------------------------------------------------------
    // Scopes & accessseurs utiles
    // ------------------------------------------------------

    public function scopeClients($query)
    {
        return $query->where('role', 'client');
    }

    public function scopeAgents($query)
    {
        return $query->where('role', 'agent');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
