<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanApplicationRequest;
use App\Mail\LoanStatusChangedMail;
use App\Models\ActivityLog;
use App\Models\LoanApplication;
use App\Services\LoanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LoanApplicationController extends Controller
{
    public function __construct(protected LoanService $loanService) {}

    public function index()
    {
        $loans = auth()->user()
            ->loanApplications()
            ->latest()
            ->paginate(10);

        return view('client.loans.index', compact('loans'));
    }

    public function create()
    {
        return view('client.loans.create');
    }

    public function store(StoreLoanApplicationRequest $request)
    {
        $loan = auth()->user()->loanApplications()->create([
            'reference' => $this->loanService->generateReference(),
            'amount_requested' => $request->input('amount_requested'),
            'duration_months' => $request->input('duration_months'),
            'interest_rate' => $request->input('interest_rate'),
            'purpose' => $request->input('purpose'),
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        ActivityLog::record('loan.submitted', $loan, 'Demande de crédit soumise');

        return redirect()->route('client.loans.show', $loan)
            ->with('success', 'Votre demande de crédit a été soumise.');
    }

    public function show(LoanApplication $loan)
    {
        $this->authorizeLoan($loan);

        return view('client.loans.show', compact('loan'));
    }

    protected function authorizeLoan(LoanApplication $loan)
    {
        if ($loan->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
