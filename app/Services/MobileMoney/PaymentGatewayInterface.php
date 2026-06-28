<?php

namespace App\Services\MobileMoney;

interface PaymentGatewayInterface
{
    /**
     * Initie un dépôt : le CLIENT paie (remboursement d'une échéance).
     * Le client reçoit un push USSD et valide avec son code PIN.
     */
    public function initiate(string $phoneNumber, float $amount, string $reference): array;

    /**
     * Initie un retrait : VOUS payez le client (octroi / décaissement
     * d'un crédit approuvé). Pas de push USSD côté client ici :
     * c'est vous qui envoyez les fonds depuis votre compte marchand.
     */
    public function payout(string $phoneNumber, float $amount, string $reference): array;

    public function verify(string $providerReference): array;

    public function isSuccess(array $response): bool;
}
