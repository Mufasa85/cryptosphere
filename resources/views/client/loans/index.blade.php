@extends('layouts.dashboard')

@section('title', 'Mes crédits')

@section('dashboard-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2>Mes demandes de crédit</h2>
    <a href="{{ route('client.loans.create') }}" class="btn btn-primary">Nouvelle demande</a>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Montant demandé</th>
                <th>Durée</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $loan)
                <tr>
                    <td>{{ $loan->reference }}</td>
                    <td>{{ number_format($loan->amount_requested, 2) }} CDF</td>
                    <td>{{ $loan->duration_months }} mois</td>
                    <td><span class="badge bg-info">{{ $loan->status }}</span></td>
                    <td>
                        <a href="{{ route('client.loans.show', $loan) }}" class="btn btn-sm btn-outline-primary">Détails</a>
                        @if(in_array($loan->status, ['disbursed', 'running']))
                            <a href="{{ route('client.repayments.create', $loan) }}" class="btn btn-sm btn-outline-success">Rembourser</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Aucune demande.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $loans->links() }}
@endsection
