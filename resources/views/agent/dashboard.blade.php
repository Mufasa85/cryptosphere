@extends('layouts.dashboard')

@section('title', 'Tableau de bord agent')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Tableau de bord agent</h2>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-label">Dossiers en attente</div>
            <div class="stat-value">{{ $pending }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-label">Nouvelles soumissions</div>
            <div class="stat-value">{{ $toReview }}</div>
        </div>
    </div>
</div>

<h4>Dernières demandes</h4>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Client</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recent as $loan)
                <tr>
                    <td><a href="{{ route('agent.validations.show', $loan) }}">{{ $loan->reference }}</a></td>
                    <td>{{ $loan->user->name }}</td>
                    <td>{{ number_format($loan->amount_requested, 2) }} CDF</td>
                    <td><span class="badge bg-primary">{{ $loan->status }}</span></td>
                    <td>{{ $loan->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Aucune demande.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
