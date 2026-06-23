<?php

namespace App\Services;

use App\Models\LoanApplication;
use App\Models\LoanSchedule;
use App\Models\Repayment;

class RepaymentService
{
    public function createPending(LoanApplication $loan, float $amount, string $mobileNumber): Repayment
    {
        return $loan->repayments()->create([
            'user_id' => auth()->id(),
            'amount' => $amount,
            'mobile_number' => $mobileNumber,
            'payment_method' => 'mobile_money',
            'status' => 'pending',
        ]);
    }

    public function confirm(Repayment $repayment): void
    {
        $repayment->update([
            'status' => 'confirmed',
            'paid_at' => now(),
        ]);

        $this->allocateToSchedule($repayment);
    }

    public function allocateToSchedule(Repayment $repayment): void
    {
        $remaining = (float) $repayment->amount;

        $schedules = $repayment->loanApplication
            ->schedules()
            ->unpaid()
            ->orderBy('installment_number')
            ->get();

        foreach ($schedules as $schedule) {
            if ($remaining <= 0) {
                break;
            }

            $due = $schedule->remaining_amount;
            $paid = min($due, $remaining);

            $schedule->paid_amount = (float) $schedule->paid_amount + $paid;
            $schedule->status = $schedule->paid_amount >= $schedule->total_amount ? 'paid' : 'partial';
            $schedule->save();

            $remaining -= $paid;
        }

        $repayment->update(['loan_schedule_id' => $schedules->first()?->id]);
    }

    public function markOverdue(LoanApplication $loan): void
    {
        $loan->schedules()
            ->where('status', '!=', 'paid')
            ->where('due_date', '<', now()->subDays(7))
            ->update(['status' => 'overdue']);
    }
}
