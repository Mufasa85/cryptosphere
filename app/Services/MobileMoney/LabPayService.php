<?php

namespace App\Services\MobileMoney;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * LabPayService
 * ---------------
 * Conforme à la doc Sandbox vérifiée sur labyrinthe-rdc.com.
 *
 * IMPORTANT : LABPAY_URL dans .env doit contenir l'URL COMPLÈTE,
 * chemin inclus : https://payment.labyrinthe-rdc.com/api/beta/mobile
 * On poste directement sur $this->baseUrl, sans rien concaténer
 * derrière pour initiate() (évite le doublon /mobile/mobile).
 *
 * Mode Sandbox : le montant et la devise sont fixés par Labyrinthe
 * (100 CDF) quel que soit ce que vous envoyez — normal en test.
 */
class LabPayService implements PaymentGatewayInterface
{
    protected string $baseUrl;
    protected string $token;
    protected string $currency;

    public function __construct()
    {
        $this->baseUrl  = rtrim(
            config('services.labpay.url', 'https://payment.labyrinthe-rdc.com/api/beta/mobile'),
            '/'
        );
        $this->token    = config('services.labpay.api_key', '');
        $this->currency = config('services.labpay.currency', 'CDF');
    }

    /**
     * Dépôt (remboursement) : POST direct sur $this->baseUrl, qui
     * contient déjà le chemin complet /api/beta/mobile.
     */
    public function initiate(string $phoneNumber, float $amount, string $reference): array
    {
        try {
            $response = Http::timeout(30)
                ->post($this->baseUrl, [
                    'token'     => $this->token,
                    'phone'     => $this->formatPhone($phoneNumber),
                    'reference' => $reference,
                ]);

            $body = $response->json() ?? [];
            $success = ($body['success'] ?? false) === true;
            $orderNumber = $body['array'][0]['data']['orderNumber'] ?? null;
            $message = $body['array'][0]['message'] ?? ($body['message'] ?? null);

            Log::info('Labyrinthe : dépôt initié', [
                'reference'    => $reference,
                'success'      => $success,
                'order_number' => $orderNumber,
                'url_appelee'  => $this->baseUrl,
            ]);

            return [
                'success'            => $success,
                'provider'           => 'labpay',
                'provider_reference' => $orderNumber,
                'message'            => $message ?? 'Réponse Labyrinthe reçue sans message explicite.',
                'raw'                => $body,
            ];
        } catch (\Exception $e) {
            Log::error('Labyrinthe : erreur réseau (dépôt)', [
                'url'   => $this->baseUrl,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'provider' => 'labpay',
                'message' => 'Erreur réseau : ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Retrait (octroi). Remplace 'mobile' par 'withdrawal' dans
     * l'URL — hypothèse non confirmée par la doc consultée (qui ne
     * documente que le dépôt sandbox). À vérifier prudemment.
     */
    public function payout(string $phoneNumber, float $amount, string $reference): array
    {
        $payoutUrl = preg_replace('#/mobile$#', '/withdrawal', $this->baseUrl);

        try {
            $response = Http::timeout(30)
                ->post($payoutUrl, [
                    'token'     => $this->token,
                    'phone'     => $this->formatPhone($phoneNumber),
                    'reference' => $reference,
                    'amount'    => $amount,
                    'currency'  => $this->currency,
                ]);

            $body = $response->json() ?? [];
            $success = ($body['success'] ?? false) === true;
            $orderNumber = $body['array'][0]['data']['orderNumber'] ?? $body['orderNumber'] ?? null;
            $message = $body['array'][0]['message'] ?? $body['message'] ?? null;

            Log::info('Labyrinthe : retrait initié — RÉPONSE BRUTE À VÉRIFIER', [
                'url'          => $payoutUrl,
                'reference'    => $reference,
                'success'      => $success,
                'order_number' => $orderNumber,
                'raw_body'     => $body,
            ]);

            return [
                'success'            => $success,
                'provider'           => 'labpay',
                'provider_reference' => $orderNumber,
                'message'            => $message ?? 'Réponse Labyrinthe reçue sans message explicite.',
                'raw'                => $body,
            ];
        } catch (\Exception $e) {
            Log::error('Labyrinthe : erreur réseau (retrait)', [
                'url'   => $payoutUrl,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'provider' => 'labpay',
                'message' => 'Erreur réseau : ' . $e->getMessage(),
            ];
        }
    }

    public function verify(string $providerReference): array
    {
        return [
            'success'            => false,
            'provider'           => 'labpay',
            'provider_reference' => $providerReference,
            'message'            => 'Endpoint de vérification non encore intégré.',
            'raw'                => [],
        ];
    }

    public function isSuccess(array $response): bool
    {
        return ($response['success'] ?? false) === true;
    }

    private function formatPhone(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);

        if (str_starts_with($digits, '243') && strlen($digits) === 12) {
            $digits = '0' . substr($digits, 3);
        }

        return $digits;
    }
}
