<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agent_id',
        'reference',
        'amount_requested',
        'amount_approved',
        'purpose',
        'duration_months',
        'interest_rate',
        'status',
        'submitted_at',
        'approved_at',
        'disbursed_at',
        'rejection_reason',
        'agent_notes',
    ];

    protected function casts(): array
    {
        return [
            'amount_requested' => 'decimal:2',
            'amount_approved'  => 'decimal:2',
            'interest_rate'    => 'decimal:2',
            'duration_months'  => 'integer',
            'submitted_at'     => 'datetime',
            'approved_at'      => 'datetime',
            'disbursed_at'     => 'datetime',
        ];
    }

    // ------------------------------------------------------
    // Relations
    // ------------------------------------------------------

    /**
     * Le client qui a fait la demande.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * L'agent qui a instruit / validé le dossier.
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Tableau d'amortissement généré pour ce crédit.
     */
    public function schedules()
    {
        return $this->hasMany(LoanSchedule::class, 'loan_application_id')
            ->orderBy('installment_number');
    }

    /**
     * Tous les remboursements liés à ce crédit.
     */
    public function repayments()
    {
        return $this->hasMany(Repayment::class, 'loan_application_id');
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class, 'loan_application_id');
    }

    public function disbursements()
    {
        return $this->hasMany(Disbursement::class, 'loan_application_id');
    }

    // ------------------------------------------------------
    // Scopes
    // ------------------------------------------------------

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['submitted', 'under_review']);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['disbursed', 'running']);
    }

    // ------------------------------------------------------
    // Accesseurs utiles
    // ------------------------------------------------------

    /**
     * Total restant à rembourser (somme des échéances non payées).
     */
    public function getOutstandingBalanceAttribute(): float
    {
        return (float) $this->schedules()
            ->whereIn('status', ['pending', 'partial', 'overdue'])
            ->sum('total_amount');
    }

    public function isApproved(): bool
    {
        return in_array($this->status, ['approved', 'disbursed', 'running', 'closed']);
    }
}
