<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanApplication;
use App\Models\LoanSchedule;
use App\Models\Penalty;
use App\Models\Repayment;

class FinancialController extends Controller
{
    public function index()
    {
        $disbursed = (float) LoanApplication::where('status', 'disbursed')->sum('amount_approved');
        $repaid = (float) Repayment::where('status', 'confirmed')->sum('amount');
        $penalties = (float) Penalty::sum('amount');
        $interest = (float) LoanSchedule::where('status', 'paid')->sum('interest_amount');
        $revenue = $interest + $penalties;

        return view('admin.financial.index', compact('disbursed', 'repaid', 'penalties', 'revenue'));
    }

    public function disbursements()
    {
        $disbursements = LoanApplication::where('status', 'disbursed')
            ->with('user', 'agent')
            ->latest('disbursed_at')
            ->paginate(15);

        return view('admin.financial.disbursements', compact('disbursements'));
    }

    public function repayments()
    {
        $repayments = Repayment::with('user', 'loanApplication')
            ->latest()
            ->paginate(15);

        return view('admin.financial.repayments', compact('repayments'));
    }

    public function penalties()
    {
        $penalties = Penalty::with('loanApplication', 'user')
            ->latest()
            ->paginate(15);

        return view('admin.financial.penalties', compact('penalties'));
    }

    public function revenue()
    {
        $interest = (float) LoanSchedule::where('status', 'paid')->sum('interest_amount');
        $penalties = (float) Penalty::where('status', 'paid')->sum('amount');
        $revenue = $interest + $penalties;

        return view('admin.financial.revenue', compact('interest', 'penalties', 'revenue'));
    }
}
