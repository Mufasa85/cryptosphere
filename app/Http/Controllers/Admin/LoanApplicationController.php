<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanApplication;
use Illuminate\Http\Request;

class LoanApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = LoanApplication::with('user', 'agent')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($sub) use ($search) {
                      $sub->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $loans = $query->paginate(15)->withQueryString();

        return view('admin.loans.index', compact('loans'));
    }

    public function show(LoanApplication $loan)
    {
        $loan->load('user', 'agent', 'schedules', 'repayments');

        return view('admin.loans.show', compact('loan'));
    }
}
