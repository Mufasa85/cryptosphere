@extends('layouts.dashboard')

@section('title', 'Validations')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Dossiers à instruire</h2>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Client</th>
                <th>Montant</th>
                <th>Durée</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $loan)
                <tr>
                    <td>{{ $loan->reference }}</td>
                    <td>{{ $loan->user->name }}</td>
                    <td>{{ number_format($loan->amount_requested, 2) }} CDF</td>
                    <td>{{ $loan->duration_months }} mois</td>
                    <td><span class="badge bg-info">{{ $loan->status }}</span></td>
                    <td>{{ $loan->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('agent.validations.show', $loan) }}" class="btn btn-sm btn-outline-primary">Instruire</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Aucun dossier.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $loans->links() }}
@endsection
