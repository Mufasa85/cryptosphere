<?php

namespace App\Services\MobileMoney;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LabPayService implements PaymentGatewayInterface
{
    protected string $baseUrl;
    protected string $apiKey;
    protected string $secret;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.labpay.url', 'https://api.labpay.test'), '/');
        $this->apiKey = config('services.labpay.api_key', '');
        $this->secret = config('services.labpay.secret', '');
    }

    public function initiate(string $phoneNumber, float $amount, string $reference): array
    {
        try {
            $response = Http::withToken($this->apiKey)
                ->timeout(30)
                ->post($this->baseUrl . '/payments/initiate', [
                    'phone_number' => $phoneNumber,
                    'amount' => $amount,
                    'currency' => 'CDF',
                    'reference' => $reference,
                    'callback_url' => route('webhooks.mobile-money'),
                ]);

            return [
                'success' => $response->successful(),
                'provider' => 'labpay',
                'provider_reference' => $response->json('transaction_id'),
                'message' => $response->json('message', 'Réponse LabPay reçue.'),
                'raw' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('LabPay initiate failed', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'provider' => 'labpay',
                'message' => 'Erreur réseau : ' . $e->getMessage(),
            ];
        }
    }

    public function verify(string $providerReference): array
    {
        try {
            $response = Http::withToken($this->apiKey)
                ->timeout(30)
                ->get($this->baseUrl . '/payments/' . $providerReference);

            return [
                'success' => $response->successful() && $response->json('status') === 'success',
                'provider' => 'labpay',
                'provider_reference' => $providerReference,
                'message' => $response->json('message', 'Vérification effectuée.'),
                'raw' => $response->json(),
            ];
        } catch (\Exception $e) {
            Log::error('LabPay verify failed', ['error' => $e->getMessage()]);

            return [
                'success' => false,
                'provider' => 'labpay',
                'message' => 'Erreur réseau : ' . $e->getMessage(),
            ];
        }
    }

    public function isSuccess(array $response): bool
    {
        return ($response['success'] ?? false) === true;
    }
}
