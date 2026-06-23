@extends('layouts.dashboard')

@section('title', 'Tous les crédits')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Tous les crédits</h2>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Client</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Agent</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $loan)
                <tr>
                    <td><a href="{{ route('agent.loans.show', $loan) }}">{{ $loan->reference }}</a></td>
                    <td>{{ $loan->user->name }}</td>
                    <td>{{ number_format($loan->amount_requested, 2) }} CDF</td>
                    <td><span class="badge bg-primary">{{ $loan->status }}</span></td>
                    <td>{{ $loan->agent?->name ?? '-' }}</td>
                    <td>{{ $loan->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Aucun crédit.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $loans->links() }}
@endsection
