<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_application_id',
        'loan_schedule_id',
        'repayment_id',
        'user_id',
        'amount',
        'reason',
        'status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function loanApplication()
    {
        return $this->belongsTo(LoanApplication::class);
    }

    public function loanSchedule()
    {
        return $this->belongsTo(LoanSchedule::class);
    }

    public function repayment()
    {
        return $this->belongsTo(Repayment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
