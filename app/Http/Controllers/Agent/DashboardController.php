<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\LoanApplication;

class DashboardController extends Controller
{
    public function index()
    {
        $pending = LoanApplication::pending()->count();
        $toReview = LoanApplication::where('status', 'submitted')->count();
        $recent = LoanApplication::with('user')
            ->latest()
            ->limit(10)
            ->get();

        return view('agent.dashboard', compact('pending', 'toReview', 'recent'));
    }
}
