<?php

namespace App\Services;

use App\Models\LoanApplication;
use App\Models\Repayment;
use App\Models\Transaction;
use App\Models\User;

class ReportService
{
    public function dashboardStats(): array
    {
        return [
            'users_count' => User::count(),
            'clients_count' => User::clients()->count(),
            'agents_count' => User::agents()->count(),
            'loans_count' => LoanApplication::count(),
            'pending_loans' => LoanApplication::pending()->count(),
            'disbursed_loans' => LoanApplication::where('status', 'disbursed')->orWhere('status', 'running')->count(),
            'total_disbursed' => (float) LoanApplication::where('status', 'disbursed')->sum('amount_approved'),
            'repayments_total' => (float) Repayment::confirmed()->sum('amount'),
            'transactions_success' => Transaction::successful()->count(),
            'transactions_failed' => Transaction::failed()->count(),
        ];
    }

    public function monthlyLoanVolume(): array
    {
        return LoanApplication::selectRaw("strftime('%Y-%m', submitted_at) as month, count(*) as count, sum(amount_requested) as amount")
            ->whereNotNull('submitted_at')
            ->groupBy('month')
            ->orderBy('month')
            ->limit(12)
            ->get()
            ->toArray();
    }

    public function statusDistribution(): array
    {
        return LoanApplication::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }
}
