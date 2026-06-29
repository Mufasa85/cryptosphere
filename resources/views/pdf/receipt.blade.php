<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Reçu #{{ $repayment->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1a2332;
            background: #ffffff;
        }

        /* ── Page wrapper ── */
        .page {
            width: 100%;
            padding: 0;
        }

        /* ── Header band ── */
        .header-band {
            background: #050B12;
            padding: 28px 40px 22px;
            color: #ffffff;
        }
        .header-top {
            width: 100%;
        }
        .header-top td {
            vertical-align: middle;
        }
        .brand-name {
            font-size: 20px;
            font-weight: bold;
            color: #3DFF7A;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .brand-sub {
            font-size: 10px;
            color: #AEBBC6;
            margin-top: 2px;
            letter-spacing: .5px;
        }
        .receipt-label {
            text-align: right;
        }
        .receipt-label-text {
            font-size: 11px;
            color: #AEBBC6;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }
        .receipt-label-title {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
            margin-top: 2px;
        }

        /* ── Green accent bar ── */
        .accent-bar {
            background: #3DFF7A;
            height: 4px;
            width: 100%;
        }

        /* ── Status banner ── */
        .status-banner {
            background: #f0faf4;
            border-left: 4px solid #3DFF7A;
            padding: 14px 40px;
            margin: 0;
        }
        .status-banner-inner {
            width: 100%;
        }
        .status-banner-inner td {
            vertical-align: middle;
        }
        .status-text {
            font-size: 11px;
            color: #1a2332;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: .5px;
            text-transform: uppercase;
        }
        .status-confirmed { background: #d1fae5; color: #065f46; }
        .status-pending   { background: #fef3c7; color: #92400e; }
        .status-failed    { background: #fee2e2; color: #991b1b; }

        /* ── Amount hero ── */
        .amount-section {
            text-align: center;
            padding: 32px 40px 24px;
            border-bottom: 1px solid #e8eef4;
        }
        .amount-label {
            font-size: 10px;
            color: #8a9ab0;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .amount-value {
            font-size: 36px;
            font-weight: bold;
            color: #050B12;
            letter-spacing: -1px;
        }
        .amount-currency {
            font-size: 16px;
            color: #8a9ab0;
            font-weight: normal;
            margin-left: 4px;
        }
        .amount-date {
            font-size: 11px;
            color: #8a9ab0;
            margin-top: 6px;
        }

        /* ── Details section ── */
        .details-section {
            padding: 28px 40px;
        }
        .details-section-title {
            font-size: 9px;
            font-weight: bold;
            color: #8a9ab0;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e8eef4;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table tr td {
            padding: 9px 0;
            border-bottom: 1px solid #f0f4f8;
            vertical-align: top;
        }
        .details-table tr:last-child td {
            border-bottom: none;
        }
        .detail-key {
            color: #8a9ab0;
            font-size: 11px;
            width: 45%;
        }
        .detail-val {
            color: #1a2332;
            font-size: 11px;
            font-weight: bold;
            text-align: right;
        }
        .detail-val-mono {
            font-family: DejaVu Sans Mono, monospace;
            font-size: 10px;
            color: #00C45A;
        }

        /* ── Two column layout ── */
        .two-col {
            width: 100%;
            border-collapse: collapse;
        }
        .two-col td {
            width: 50%;
            vertical-align: top;
            padding: 0;
        }
        .col-divider {
            width: 1px;
            background: #e8eef4;
        }

        /* ── Reference box ── */
        .ref-box {
            background: #f8fafc;
            border: 1px dashed #c8d6e0;
            border-radius: 6px;
            padding: 16px 20px;
            margin: 0 40px 28px;
            text-align: center;
        }
        .ref-box-label {
            font-size: 9px;
            color: #8a9ab0;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .ref-box-value {
            font-family: DejaVu Sans Mono, monospace;
            font-size: 14px;
            color: #050B12;
            font-weight: bold;
            letter-spacing: 2px;
        }
        .ref-box-id {
            font-size: 9px;
            color: #8a9ab0;
            margin-top: 4px;
        }

        /* ── Footer ── */
        .footer-band {
            background: #050B12;
            padding: 18px 40px;
            margin-top: 0;
        }
        .footer-inner {
            width: 100%;
        }
        .footer-inner td {
            vertical-align: middle;
        }
        .footer-left {
            color: #AEBBC6;
            font-size: 9px;
            line-height: 1.6;
        }
        .footer-right {
            text-align: right;
            color: #3DFF7A;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: .5px;
        }

        /* ── Watermark ── */
        .watermark-wrap {
            position: relative;
        }
        .section-divider {
            border: none;
            border-top: 1px solid #e8eef4;
            margin: 0 40px;
        }
    </style>
</head>
<body>
<div class="page">

    {{-- ══ HEADER ══ --}}
    <div class="header-band">
        <table class="header-top" style="width:100%;">
            <tr>
                <td>
                    <div class="brand-name">{{ config('app.name') }}</div>
                    <div class="brand-sub">Système de gestion de crédits</div>
                </td>
                <td class="receipt-label">
                    <div class="receipt-label-text">Document officiel</div>
                    <div class="receipt-label-title">Reçu de remboursement</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="accent-bar"></div>

    {{-- ══ STATUS BANNER ══ --}}
    @php
        $statusMap = [
            'confirmed' => ['confirmed', 'Paiement confirmé'],
            'pending'   => ['pending',   'Paiement en attente'],
            'failed'    => ['failed',    'Paiement échoué'],
        ];
        [$sCls, $sTxt] = $statusMap[$repayment->status] ?? ['pending', $repayment->status];
    @endphp
    <div class="status-banner">
        <table class="status-banner-inner" style="width:100%;">
            <tr>
                <td>
                    <span class="status-text">Statut du paiement</span>
                </td>
                <td style="text-align:right;">
                    <span class="status-badge status-{{ $sCls }}">{{ $sTxt }}</span>
                </td>
            </tr>
        </table>
    </div>

    {{-- ══ AMOUNT HERO ══ --}}
    <div class="amount-section">
        <div class="amount-label">Montant remboursé</div>
        <div class="amount-value">
            {{ number_format($repayment->amount, 2) }}<span class="amount-currency">CDF</span>
        </div>
        <div class="amount-date">
            {{ $repayment->paid_at?->format('d/m/Y à H:i') ?? now()->format('d/m/Y à H:i') }}
        </div>
    </div>

    {{-- ══ DETAILS ══ --}}
    <div class="details-section">
        <div class="details-section-title">Détails du paiement</div>

        <table class="two-col" style="width:100%;">
            <tr>
                <td style="padding-right:20px;">
                    {{-- Colonne gauche : infos client --}}
                    <table class="details-table" style="width:100%;">
                        <tr>
                            <td class="detail-key">Client</td>
                            <td class="detail-val">{{ $repayment->user->name }}</td>
                        </tr>
                        <tr>
                            <td class="detail-key">Email</td>
                            <td class="detail-val" style="font-size:10px;">{{ $repayment->user->email }}</td>
                        </tr>
                        <tr>
                            <td class="detail-key">Téléphone</td>
                            <td class="detail-val">{{ $repayment->user->phone ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="detail-key">Numéro Mobile Money</td>
                            <td class="detail-val">{{ $repayment->mobile_number }}</td>
                        </tr>
                    </table>
                </td>
                <td class="col-divider"></td>
                <td style="padding-left:20px;">
                    {{-- Colonne droite : infos transaction --}}
                    <table class="details-table" style="width:100%;">
                        <tr>
                            <td class="detail-key">Référence crédit</td>
                            <td class="detail-val detail-val-mono">{{ $repayment->loanApplication->reference }}</td>
                        </tr>
                        <tr>
                            <td class="detail-key">N° reçu</td>
                            <td class="detail-val detail-val-mono">REC-{{ str_pad($repayment->id, 6, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <td class="detail-key">Méthode de paiement</td>
                            <td class="detail-val">{{ ucfirst(str_replace('_', ' ', $repayment->payment_method)) }}</td>
                        </tr>
                        <tr>
                            <td class="detail-key">Date d'émission</td>
                            <td class="detail-val">{{ now()->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <hr class="section-divider">

    {{-- ══ LOAN DETAILS ══ --}}
    <div class="details-section" style="padding-top:18px;padding-bottom:18px;">
        <div class="details-section-title">Informations sur le crédit</div>
        <table class="details-table" style="width:100%;">
            <tr>
                <td class="detail-key">Montant approuvé</td>
                <td class="detail-val">{{ $repayment->loanApplication->amount_approved ? number_format($repayment->loanApplication->amount_approved, 2).' CDF' : '—' }}</td>
                <td class="detail-key" style="padding-left:30px;">Durée</td>
                <td class="detail-val">{{ $repayment->loanApplication->duration_months }} mois</td>
            </tr>
            <tr>
                <td class="detail-key">Taux d'intérêt</td>
                <td class="detail-val">{{ $repayment->loanApplication->interest_rate }} %</td>
                <td class="detail-key" style="padding-left:30px;">Statut crédit</td>
                <td class="detail-val">{{ ucfirst($repayment->loanApplication->status) }}</td>
            </tr>
        </table>
    </div>

    {{-- ══ REFERENCE BOX ══ --}}
    <div class="ref-box">
        <div class="ref-box-label">Identifiant unique du reçu</div>
        <div class="ref-box-value">REC-{{ str_pad($repayment->id, 6, '0', STR_PAD_LEFT) }} &nbsp;·&nbsp; {{ $repayment->loanApplication->reference }}</div>
        <div class="ref-box-id">Généré le {{ now()->format('d/m/Y à H:i:s') }} &nbsp;·&nbsp; Document officiel non modifiable</div>
    </div>

    {{-- ══ FOOTER ══ --}}
    <div class="footer-band">
        <table class="footer-inner" style="width:100%;">
            <tr>
                <td class="footer-left">
                    {{ config('app.name') }} &nbsp;·&nbsp; Système de gestion de crédits<br>
                    Ce document est généré automatiquement et constitue une preuve officielle de paiement.
                </td>
                <td class="footer-right">
                    Merci pour votre confiance
                </td>
            </tr>
        </table>
    </div>

</div>
</body>
</html>
