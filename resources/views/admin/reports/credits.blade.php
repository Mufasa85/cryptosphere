@extends('layouts.dashboard')

@section('title', 'Rapport des crédits')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom d-flex justify-content-between align-items-center">
    <h2>Rapport des crédits</h2>
    <div>
        <a href="{{ route('admin.reports.credits', ['format' => 'csv'] + request()->query()) }}" class="btn btn-outline-secondary">Export Excel</a>
        <a href="{{ route('admin.reports.index', ['format' => 'pdf']) }}" class="btn btn-outline-secondary">Export PDF</a>
    </div>
</div>

<div class="row mb-4">
    @foreach([
        ['Total', $stats['total']],
        ['Décaissés', $stats['disbursed']],
        ['Remboursé', number_format($stats['repaid'], 2) . ' CDF'],
        ['Encours', number_format($stats['outstanding'], 2) . ' CDF'],
    ] as $card)
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="text-muted">{{ $card[0] }}</div>
                    <div class="fw-bold fs-5">{{ $card[1] }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-3 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">-- Statut --</option>
                    @foreach(['submitted', 'under_review', 'approved', 'disbursed', 'rejected', 'closed'] as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filtrer</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Client</th>
                        <th>Montant demandé</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        <tr>
                            <td>{{ $loan->reference }}</td>
                            <td>{{ $loan->user?->name }}</td>
                            <td>{{ number_format($loan->amount_requested, 2) }} CDF</td>
                            <td><span class="badge bg-secondary">{{ $loan->status }}</span></td>
                            <td>{{ $loan->created_at?->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Aucun crédit.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $loans->links() }}
    </div>
</div>
@endsection
