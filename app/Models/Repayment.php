<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_application_id',
        'loan_schedule_id',
        'user_id',
        'amount',
        'payment_method',
        'mobile_number',
        'status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount'  => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    // ------------------------------------------------------
    // Relations
    // ------------------------------------------------------

    /**
     * Le crédit concerné par ce remboursement.
     */
    public function loanApplication()
    {
        return $this->belongsTo(LoanApplication::class, 'loan_application_id');
    }

    /**
     * L'échéance que ce paiement couvre (peut être nulle).
     */
    public function loanSchedule()
    {
        return $this->belongsTo(LoanSchedule::class, 'loan_schedule_id');
    }

    /**
     * Le client qui a effectué ce paiement.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Trace technique des appels à l'opérateur de paiement (LabPay...).
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'repayment_id');
    }

    /**
     * Dernière transaction tentée pour ce remboursement.
     */
    public function latestTransaction()
    {
        return $this->hasOne(Transaction::class, 'repayment_id')->latestOfMany();
    }

    // ------------------------------------------------------
    // Scopes
    // ------------------------------------------------------

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'processing']);
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }
}
