@extends('layouts.dashboard')

@section('title', 'Détail client')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>{{ $client->name }}</h2>
</div>

<div class="card mb-3">
    <div class="card-body">
        <p><strong>Email :</strong> {{ $client->email }}</p>
        <p><strong>Téléphone :</strong> {{ $client->phone }}</p>
        <p><strong>Compte :</strong> {{ $client->is_active ? 'Actif' : 'Inactif' }}</p>
    </div>
</div>

<h4>Demandes de crédit</h4>
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
            @forelse($client->loanApplications as $loan)
                <tr>
                    <td>{{ $loan->reference }}</td>
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
