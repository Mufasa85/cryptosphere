<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateLoanRequest;
use App\Mail\LoanStatusChangedMail;
use App\Models\LoanApplication;
use App\Services\LoanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ValidationController extends Controller
{
    public function __construct(protected LoanService $loanService) {}

    public function index()
    {
        $loans = LoanApplication::with('user')
            ->whereIn('status', ['submitted', 'under_review', 'approved'])
            ->latest()
            ->paginate(15);

        return view('agent.validations.index', compact('loans'));
    }

    public function show(LoanApplication $loan)
    {
        $loan->load('user', 'schedules');

        return view('agent.validations.show', compact('loan'));
    }

    public function validate(ValidateLoanRequest $request, LoanApplication $loan)
    {
        $this->loanService->approve($loan, $request->validated());

        Mail::to($loan->user)->queue(new LoanStatusChangedMail($loan, 'approved'));

        return redirect()->route('agent.validations.index')
            ->with('success', 'Dossier approuvé.');
    }

    public function reject(Request $request, LoanApplication $loan)
    {
        $data = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:2000'],
        ]);

        $this->loanService->reject($loan, $data['rejection_reason']);

        Mail::to($loan->user)->queue(new LoanStatusChangedMail($loan, 'rejected'));

        return redirect()->route('agent.validations.index')
            ->with('success', 'Dossier rejeté.');
    }

    public function disburse(LoanApplication $loan)
    {
        if (! $loan->isApproved()) {
            return back()->withErrors(['Le crédit n\'est pas encore approuvé.']);
        }

        $this->loanService->disburse($loan);

        Mail::to($loan->user)->queue(new LoanStatusChangedMail($loan, 'disbursed'));

        return redirect()->route('agent.validations.index')
            ->with('success', 'Crédit décaissé et échéancier généré.');
    }
}
