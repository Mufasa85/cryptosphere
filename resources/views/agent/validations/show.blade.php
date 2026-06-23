@extends('layouts.dashboard')

@section('title', 'Instruire le dossier')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Instruire {{ $loan->reference }}</h2>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Demande</h5>
                <p><strong>Client :</strong> {{ $loan->user->name }}</p>
                <p><strong>Email :</strong> {{ $loan->user->email }}</p>
                <p><strong>Montant demandé :</strong> {{ number_format($loan->amount_requested, 2) }} CDF</p>
                <p><strong>Durée :</strong> {{ $loan->duration_months }} mois</p>
                <p><strong>Taux :</strong> {{ $loan->interest_rate }} %</p>
                <p><strong>Motif :</strong> {{ $loan->purpose }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        @if($loan->status === 'submitted' || $loan->status === 'under_review')
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Approuver</h5>
                    <form method="POST" action="{{ route('agent.validations.approve', $loan) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Montant approuvé</label>
                            <input type="number" step="0.01" name="amount_approved" class="form-control" value="{{ $loan->amount_requested }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Taux d'intérêt (%)</label>
                            <input type="number" step="0.01" name="interest_rate" class="form-control" value="{{ $loan->interest_rate }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Durée (mois)</label>
                            <input type="number" name="duration_months" class="form-control" value="{{ $loan->duration_months }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="agent_notes" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Approuver</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Rejeter</h5>
                    <form method="POST" action="{{ route('agent.validations.reject', $loan) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Motif du rejet</label>
                            <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">Rejeter</button>
                    </form>
                </div>
            </div>
        @endif

        @if($loan->status === 'approved')
            <form method="POST" action="{{ route('agent.validations.disburse', $loan) }}">
                @csrf
                <button type="submit" class="btn btn-warning">Décaisser le crédit</button>
            </form>
        @endif
    </div>
</div>
@endsection
