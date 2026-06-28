<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Disbursement;
use App\Models\Repayment;
use App\Models\Transaction;
use App\Services\LoanService;
use App\Services\RepaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MobileMoneyWebhookController extends Controller
{
    public function __construct(
        protected RepaymentService $repaymentService,
        protected LoanService $loanService,
    ) {}

    public function __invoke(Request $request)
    {
        // Toujours loguer le payload BRUT en premier, avant tout traitement.
        // Indispensable pour inspecter le vrai format du callback Labyrinthe
        // dès que le réseau sera disponible.
        Log::info('MobileMoney webhook — payload brut reçu', [
            'headers' => $request->headers->all(),
            'body'    => $request->all(),
        ]);

        $payload           = $request->all();
        $status            = $payload['status'] ?? null;
        $providerReference = $payload['provider_reference'] ?? ($payload['orderNumber'] ?? null);
        $isSuccess         = in_array($status, ['success', 'completed', 'SUCCESSFUL'], true);

        if (! $providerReference) {
            Log::warning('MobileMoney webhook — provider_reference manquant', $payload);

            return response()->json(['message' => 'Payload invalide : provider_reference manquant.'], 400);
        }

        // --- Cherche d'abord dans les transactions de remboursement ---
        $transaction = Transaction::where('provider_reference', $providerReference)->first();

        if ($transaction && $transaction->repayment) {
            return $this->handleRepaymentCallback($transaction->repayment, $payload, $providerReference, $isSuccess);
        }

        // --- Cherche ensuite dans les décaissements ---
        $disbursement = Disbursement::where('provider_reference', $providerReference)->first();

        if ($disbursement) {
            return $this->handleDisbursementCallback($disbursement, $payload, $providerReference, $isSuccess);
        }

        Log::warning('MobileMoney webhook — aucune correspondance trouvée', [
            'provider_reference' => $providerReference,
        ]);

        return response()->json(['message' => 'Référence introuvable.'], 404);
    }

    private function handleRepaymentCallback(
        Repayment $repayment,
        array $payload,
        string $providerReference,
        bool $isSuccess
    ) {
        $repayment->transactions()->create([
            'provider'           => $payload['provider'] ?? 'mobile_money',
            'provider_reference' => $providerReference,
            'request_payload'    => $payload,
            'response_payload'   => $payload,
            'status'             => $isSuccess ? 'success' : 'failed',
        ]);

        if ($isSuccess && ! $repayment->isConfirmed()) {
            $this->repaymentService->confirm($repayment);

            Log::info('MobileMoney webhook — remboursement confirmé', [
                'repayment_id'       => $repayment->id,
                'provider_reference' => $providerReference,
            ]);
        } elseif (! $isSuccess) {
            $repayment->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'Remboursement traité.']);
    }

    private function handleDisbursementCallback(
        Disbursement $disbursement,
        array $payload,
        string $providerReference,
        bool $isSuccess
    ) {
        if ($isSuccess && ! $disbursement->isConfirmed()) {
            $disbursement->update([
                'status'       => 'confirmed',
                'disbursed_at' => now(),
            ]);

            $loan = $disbursement->loanApplication;
            $this->loanService->confirmDisbursement($loan);

            Log::info('MobileMoney webhook — décaissement confirmé', [
                'disbursement_id'    => $disbursement->id,
                'loan_id'            => $loan->id,
                'provider_reference' => $providerReference,
            ]);
        } elseif (! $isSuccess) {
            $disbursement->update(['status' => 'failed']);

            Log::warning('MobileMoney webhook — décaissement échoué', [
                'disbursement_id'    => $disbursement->id,
                'provider_reference' => $providerReference,
                'payload'            => $payload,
            ]);
        }

        return response()->json(['message' => 'Décaissement traité.']);
    }
}
