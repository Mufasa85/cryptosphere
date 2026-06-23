<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Repayment;

class RepaymentController extends Controller
{
    public function index()
    {
        $repayments = Repayment::with('user', 'loanApplication')
            ->latest()
            ->paginate(15);

        return view('agent.repayments.index', compact('repayments'));
    }
}
