@extends('layouts.dashboard')

@section('title', 'Encaisser un remboursement')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Encaisser un remboursement</h2>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('agent.repayments.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Crédit / Client</label>
                <select name="loan_application_id" class="form-select" required>
                    <option value="">-- Sélectionner un crédit --</option>
                    @foreach($loans as $loan)
                        <option value="{{ $loan->id }}" {{ old('loan_application_id') == $loan->id ? 'selected' : '' }}>
                            {{ $loan->reference }} — {{ $loan->user->name }} (Solde : {{ number_format($loan->outstanding_balance, 2) }} CDF)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Montant</label>
                    <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Méthode de paiement</label>
                    <select name="payment_method" class="form-select" required>
                        <option value="mobile_money" {{ old('payment_method') == 'mobile_money' ? 'selected' : '' }}>Mobile money</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Espèces</option>
                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Virement bancaire</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Numéro mobile</label>
                    <input type="text" name="mobile_number" class="form-control" value="{{ old('mobile_number') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Statut</label>
                    <select name="status" class="form-select" required>
                        <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    </select>
                </div>
            </div>

            <button class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('agent.repayments.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection
