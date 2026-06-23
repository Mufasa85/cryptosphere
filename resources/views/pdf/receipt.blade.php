<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reçu de paiement</title>
    <style>
        body { font-family: sans-serif; font-size: 13px; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; }
        .label { font-weight: bold; }
        .amount { font-size: 18px; font-weight: bold; color: #198754; }
        .footer { margin-top: 30px; text-align: center; font-size: 11px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ config('app.name') }}</h2>
        <p>Reçu de remboursement</p>
    </div>

    <p><span class="label">Référence crédit :</span> {{ $repayment->loanApplication->reference }}</p>
    <p><span class="label">Client :</span> {{ $repayment->user->name }}</p>
    <p><span class="label">Email :</span> {{ $repayment->user->email }}</p>
    <p><span class="label">Téléphone :</span> {{ $repayment->mobile_number }}</p>
    <p><span class="label">Date :</span> {{ $repayment->paid_at?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }}</p>
    <p><span class="label">Méthode :</span> {{ $repayment->payment_method }}</p>
    <p class="amount">Montant : {{ number_format($repayment->amount, 2) }} CDF</p>

    <div class="footer">
        Merci pour votre confiance.<br>
        Ce reçu est généré automatiquement.
    </div>
</body>
</html>
