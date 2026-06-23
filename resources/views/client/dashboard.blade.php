@extends('layouts.dashboard')

@section('title', 'Tableau de bord client')

@section('dashboard-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>Tableau de bord</h2>
    <a href="{{ route('client.loans.create') }}" class="btn btn-primary">Nouvelle demande</a>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-label">Crédits en cours</div>
            <div class="stat-value">{{ number_format($outstanding, 2) }} CDF</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-label">Demandes</div>
            <div class="stat-value">{{ $loans->count() }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-label">Remboursements</div>
            <div class="stat-value">{{ $repayments->count() }}</div>
        </div>
    </div>
</div>

<h4>Dernières demandes</h4>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $loan)
                <tr>
                    <td><a href="{{ route('client.loans.show', $loan) }}">{{ $loan->reference }}</a></td>
                    <td>{{ number_format($loan->amount_requested, 2) }} CDF</td>
                    <td><span class="badge bg-primary">{{ $loan->status }}</span></td>
                    <td>{{ $loan->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Aucune demande.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
