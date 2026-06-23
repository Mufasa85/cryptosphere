<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $loans = $user->loanApplications()->latest()->limit(5)->get();
        $repayments = $user->repayments()->latest()->limit(5)->get();
        $outstanding = $user->loanApplications()->whereIn('status', ['disbursed', 'running'])->sum('amount_approved');

        return view('client.dashboard', compact('loans', 'repayments', 'outstanding'));
    }
}
