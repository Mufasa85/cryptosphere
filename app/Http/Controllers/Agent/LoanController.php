<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\LoanApplication;

class LoanController extends Controller
{
    public function index()
    {
        $loans = LoanApplication::with('user', 'agent')
            ->latest()
            ->paginate(15);

        return view('agent.loans.index', compact('loans'));
    }

    public function show(LoanApplication $loan)
    {
        return view('agent.loans.show', compact('loan'));
    }
}
