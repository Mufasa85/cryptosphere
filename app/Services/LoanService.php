<?php

namespace App\Services;

use App\Models\LoanApplication;
use App\Models\LoanSchedule;
use Carbon\Carbon;
use Illuminate\Support\Str;

class LoanService
{
    public function generateReference(): string
    {
        return 'CRD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(5));
    }

    public function createSchedule(LoanApplication $loan): void
    {
        $loan->schedules()->delete();

        $principal = (float) $loan->amount_approved;
        $rate = (float) $loan->interest_rate / 100;
        $duration = (int) $loan->duration_months;

        if ($duration <= 0 || $principal <= 0) {
            return;
        }

        $monthlyInterest = $principal * $rate / $duration;
        $monthlyPrincipal = $principal / $duration;
        $monthlyTotal = $monthlyPrincipal + $monthlyInterest;

        $start = Carbon::parse($loan->disbursed_at ?: now());

        for ($i = 1; $i <= $duration; $i++) {
            $loan->schedules()->create([
                'installment_number' => $i,
                'due_date' => $start->copy()->addMonths($i),
                'principal_amount' => round($monthlyPrincipal, 2),
                'interest_amount' => round($monthlyInterest, 2),
                'total_amount' => round($monthlyTotal, 2),
                'paid_amount' => 0,
                'status' => 'pending',
            ]);
        }
    }

    public function approve(LoanApplication $loan, array $data): void
    {
        $loan->update([
            'agent_id' => auth()->id(),
            'amount_approved' => $data['amount_approved'],
            'interest_rate' => $data['interest_rate'],
            'duration_months' => $data['duration_months'],
            'status' => 'approved',
            'approved_at' => now(),
            'agent_notes' => $data['agent_notes'] ?? null,
        ]);
    }

    public function reject(LoanApplication $loan, string $reason): void
    {
        $loan->update([
            'agent_id' => auth()->id(),
            'status' => 'rejected',
            'rejection_reason' => $reason,
        ]);
    }

    public function disburse(LoanApplication $loan): void
    {
        $loan->update([
            'status' => 'disbursed',
            'disbursed_at' => now(),
        ]);

        $this->createSchedule($loan);
    }
}
