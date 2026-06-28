<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disbursement extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_application_id',
        'agent_id',
        'amount',
        'mobile_number',
        'provider_reference',
        'provider',
        'status',
        'disbursed_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'       => 'decimal:2',
            'disbursed_at' => 'datetime',
        ];
    }

    public function loanApplication()
    {
        return $this->belongsTo(LoanApplication::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }
}
