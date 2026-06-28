<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateLoanRequest;
use App\Mail\LoanStatusChangedMail;
use App\Models\ActivityLog;
use App\Models\Disbursement;
use App\Models\LoanApplication;
use App\Services\LoanService;
use App\Services\MobileMoney\PaymentGatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ValidationController extends Controller
{
    public function __construct(
        protected LoanService $loanService,
        protected PaymentGatewayInterface $gateway,
    ) {}

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

        ActivityLog::record('loan.approved', $loan, 'Dossier approuvé');
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

        ActivityLog::record('loan.rejected', $loan, 'Dossier rejeté : ' . $data['rejection_reason']);
        Mail::to($loan->user)->queue(new LoanStatusChangedMail($loan, 'rejected'));

        return redirect()->route('agent.validations.index')
            ->with('success', 'Dossier rejeté.');
    }

    public function disburse(LoanApplication $loan)
    {
        if ($loan->status !== 'approved') {
            return back()->withErrors(['Le crédit n\'est pas en statut "approuvé".']);
        }

        $client = $loan->user;

        if (! $client->phone) {
            return back()->withErrors(['Le client n\'a pas de numéro de téléphone mobile enregistré.']);
        }

        $disbursement = DB::transaction(function () use ($loan, $client) {
            $disbursement = Disbursement::create([
                'loan_application_id' => $loan->id,
                'agent_id'            => auth()->id(),
                'amount'              => $loan->amount_approved,
                'mobile_number'       => $client->phone,
                'status'              => 'processing',
            ]);

            $reference = 'DISB-' . $loan->reference;

            $response = $this->gateway->payout(
                $client->phone,
                (float) $loan->amount_approved,
                $reference
            );

            Log::info('Décaissement initié', [
                'loan_id'            => $loan->id,
                'disbursement_id'    => $disbursement->id,
                'gateway_success'    => $response['success'] ?? false,
                'provider_reference' => $response['provider_reference'] ?? null,
            ]);

            if (! ($response['success'] ?? false)) {
                $disbursement->update(['status' => 'failed']);

                return ['disbursement' => $disbursement, 'failed' => true, 'message' => $response['message'] ?? 'Échec du décaissement.'];
            }

            $disbursement->update([
                'status'             => 'processing',
                'provider_reference' => $response['provider_reference'] ?? null,
            ]);

            $loan->update(['status' => 'disbursed', 'disbursed_at' => now()]);

            return ['disbursement' => $disbursement, 'failed' => false, 'message' => null];
        });

        if ($disbursement['failed']) {
            return back()->withErrors([$disbursement['message']]);
        }

        ActivityLog::record('loan.disbursed', $loan, 'Décaissement mobile money initié, en attente de confirmation');
        Mail::to($client)->queue(new LoanStatusChangedMail($loan, 'disbursed'));

        return redirect()->route('agent.validations.index')
            ->with('success', 'Décaissement initié via mobile money. En attente de confirmation du paiement.');
    }
}
