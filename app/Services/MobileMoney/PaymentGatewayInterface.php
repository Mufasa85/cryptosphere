<?php

namespace App\Services\MobileMoney;

interface PaymentGatewayInterface
{
    public function initiate(string $phoneNumber, float $amount, string $reference): array;

    public function verify(string $providerReference): array;

    public function isSuccess(array $response): bool;
}
