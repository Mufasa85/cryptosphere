<?php

namespace App\Services\MobileMoney;

class MockService implements PaymentGatewayInterface
{
    public function initiate(string $phoneNumber, float $amount, string $reference): array
    {
        $success = (random_int(1, 100) <= 90);

        return [
            'success'            => $success,
            'provider'           => 'mock',
            'provider_reference' => 'MOCK-DEP-' . strtoupper(uniqid()),
            'message'            => $success
                ? 'Dépôt simulé initié avec succès (mock 90 %).'
                : 'Échec simulé du dépôt (mock 10 %).',
        ];
    }

    public function payout(string $phoneNumber, float $amount, string $reference): array
    {
        $success = (random_int(1, 100) <= 95);

        return [
            'success'            => $success,
            'provider'           => 'mock',
            'provider_reference' => 'MOCK-PAY-' . strtoupper(uniqid()),
            'message'            => $success
                ? 'Décaissement simulé effectué avec succès (mock 95 %).'
                : 'Échec simulé du décaissement (mock 5 %).',
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
