<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLoanApplicationRequest;
use App\Models\LoanApplication;
use App\Services\LoanService;
use Illuminate\Http\Request;

class LoanApplicationController extends Controller
{
    public function __construct(protected LoanService $loanService) {}

    public function index()
    {
        $loans = auth()->user()->loanApplications()->latest()->paginate(10);

        return response()->json($loans);
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

        return response()->json($loan->load('user'), 201);
    }

    public function show(LoanApplication $loan)
    {
        $this->authorizeLoan($loan);

        return response()->json($loan->load('schedules', 'repayments'));
    }

    public function update(StoreLoanApplicationRequest $request, LoanApplication $loan)
    {
        $this->authorizeLoan($loan);

        if (! in_array($loan->status, ['submitted', 'under_review'])) {
            return response()->json(['message' => 'Modification impossible.'], 422);
        }

        $loan->update($request->only(['amount_requested', 'duration_months', 'interest_rate', 'purpose']));

        return response()->json($loan);
    }

    public function destroy(LoanApplication $loan)
    {
        $this->authorizeLoan($loan);

        if ($loan->status !== 'submitted') {
            return response()->json(['message' => 'Suppression impossible.'], 422);
        }

        $loan->delete();

        return response()->json(['message' => 'Demande supprimée.']);
    }

    protected function authorizeLoan(LoanApplication $loan)
    {
        if ($loan->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }
    }
}
