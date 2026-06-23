<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'repayment_id',
        'provider',
        'provider_reference',
        'request_payload',
        'response_payload',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'request_payload'  => 'array',
            'response_payload' => 'array',
        ];
    }

    // ------------------------------------------------------
    // Relations
    // ------------------------------------------------------

    /**
     * Le remboursement auquel cette transaction technique se rattache.
     */
    public function repayment()
    {
        return $this->belongsTo(Repayment::class, 'repayment_id');
    }

    // ------------------------------------------------------
    // Scopes
    // ------------------------------------------------------

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeFailed($query)
    {
        return $query->whereIn('status', ['failed', 'timeout']);
    }

    public function isSuccessful(): bool
    {
        return $this->status === 'success';
    }
}
