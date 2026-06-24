<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_application_id',
        'installment_number',
        'due_date',
        'principal_amount',
        'interest_amount',
        'total_amount',
        'paid_amount',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'due_date'          => 'date',
            'principal_amount'  => 'decimal:2',
            'interest_amount'   => 'decimal:2',
            'total_amount'      => 'decimal:2',
            'paid_amount'       => 'decimal:2',
            'installment_number' => 'integer',
        ];
    }

    // ------------------------------------------------------
    // Relations
    // ------------------------------------------------------

    /**
     * Le crédit auquel appartient cette échéance.
     */
    public function loanApplication()
    {
        return $this->belongsTo(LoanApplication::class, 'loan_application_id');
    }

    /**
     * Remboursements qui ont été affectés à cette échéance.
     */
    public function repayments()
    {
        return $this->hasMany(Repayment::class, 'loan_schedule_id');
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class, 'loan_schedule_id');
    }

    // ------------------------------------------------------
    // Scopes
    // ------------------------------------------------------

    public function scopeUnpaid($query)
    {
        return $query->whereIn('status', ['pending', 'partial', 'overdue']);
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', '!=', 'paid')
            ->where('due_date', '<', now());
    }

    // ------------------------------------------------------
    // Accesseurs utiles
    // ------------------------------------------------------

    public function getRemainingAmountAttribute(): float
    {
        return (float) ($this->total_amount - $this->paid_amount);
    }

    public function isFullyPaid(): bool
    {
        return $this->status === 'paid';
    }
}
