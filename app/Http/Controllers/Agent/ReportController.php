<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\LoanApplication;
use App\Models\Repayment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function daily(Request $request)
    {
        $date = $request->date('date') ?? today();

        $repayments = (float) Repayment::whereDate('created_at', $date)
            ->where('status', 'confirmed')
            ->sum('amount');

        $disbursements = (float) LoanApplication::whereDate('disbursed_at', $date)
            ->sum('amount_approved');

        $submissions = LoanApplication::whereDate('submitted_at', $date)->count();

        $details = Repayment::with('user', 'loanApplication')
            ->whereDate('created_at', $date)
            ->latest()
            ->get();

        return view('agent.reports.daily', compact('date', 'repayments', 'disbursements', 'submissions', 'details'));
    }

    public function monthly(Request $request)
    {
        $month = $request->input('month') ?? now()->format('Y-m');
        [$year, $mon] = explode('-', $month);

        $repayments = (float) Repayment::whereYear('created_at', $year)
            ->whereMonth('created_at', $mon)
            ->where('status', 'confirmed')
            ->sum('amount');

        $disbursements = (float) LoanApplication::whereYear('disbursed_at', $year)
            ->whereMonth('disbursed_at', $mon)
            ->sum('amount_approved');

        $submissions = LoanApplication::whereYear('submitted_at', $year)
            ->whereMonth('submitted_at', $mon)
            ->count();

        $details = Repayment::with('user', 'loanApplication')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $mon)
            ->latest()
            ->get();

        return view('agent.reports.monthly', compact('month', 'repayments', 'disbursements', 'submissions', 'details'));
    }
}
