@extends('layouts.dashboard')

@section('title', 'Gestion des crédits')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Tous les crédits</h2>
</div>

<form method="GET" class="row g-3 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Référence ou client..." value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">Tous les statuts</option>
            <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Soumis</option>
            <option value="under_review" {{ request('status') === 'under_review' ? 'selected' : '' }}>En cours</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approuvé</option>
            <option value="disbursed" {{ request('status') === 'disbursed' ? 'selected' : '' }}>Décaissé</option>
            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejeté</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-outline-primary">Filtrer</button>
    </div>
</form>

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
                    <td><a href="{{ route('admin.loans.show', $loan) }}">{{ $loan->reference }}</a></td>
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
