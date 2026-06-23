<?php

namespace App\Services\MobileMoney;

class MockService implements PaymentGatewayInterface
{
    public function initiate(string $phoneNumber, float $amount, string $reference): array
    {
        return [
            'success' => true,
            'provider' => 'mock',
            'provider_reference' => 'MOCK-' . strtoupper(uniqid()),
            'message' => 'Paiement simulé initié avec succès.',
        ];
    }

    public function verify(string $providerReference): array
    {
        return [
            'success' => true,
            'provider' => 'mock',
            'provider_reference' => $providerReference,
            'message' => 'Paiement simulé confirmé.',
        ];
    }

    public function isSuccess(array $response): bool
    {
        return ($response['success'] ?? false) === true;
    }
}
