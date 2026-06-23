<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Repayment;
use App\Services\RepaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MobileMoneyWebhookController extends Controller
{
    public function __construct(protected RepaymentService $repaymentService) {}

    public function __invoke(Request $request)
    {
        $payload = $request->all();
        Log::info('Mobile money webhook received', $payload);

        $repaymentId = $payload['repayment_id'] ?? null;
        $status = $payload['status'] ?? null;
        $providerReference = $payload['provider_reference'] ?? null;

        if (! $repaymentId || ! $status) {
            return response()->json(['message' => 'Payload invalide.'], 400);
        }

        $repayment = Repayment::find($repaymentId);

        if (! $repayment) {
            return response()->json(['message' => 'Paiement introuvable.'], 404);
        }

        $repayment->transactions()->create([
            'provider' => $payload['provider'] ?? 'mobile_money',
            'provider_reference' => $providerReference,
            'request_payload' => $payload,
            'response_payload' => $payload,
            'status' => $status === 'success' ? 'success' : 'failed',
        ]);

        if ($status === 'success' && ! $repayment->isConfirmed()) {
            $this->repaymentService->confirm($repayment);
        }

        if ($status !== 'success') {
            $repayment->update(['status' => 'failed']);
        }

        return response()->json(['message' => 'Webhook traité.']);
    }
}
