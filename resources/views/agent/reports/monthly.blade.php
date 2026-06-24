@extends('layouts.dashboard')

@section('title', 'Rapport mensuel')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Rapport mensuel</h2>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="month" name="month" class="form-control" value="{{ old('month', $month) }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Afficher</button>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">
    @foreach([
        ['Remboursements', number_format($repayments, 2) . ' CDF', 'cash-stack'],
        ['Décaissements', number_format($disbursements, 2) . ' CDF', 'bank'],
        ['Demandes', $submissions, 'file-earmark-text'],
    ] as $card)
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-{{ $card[2] }} fs-1" style="color:#3DFF7A;"></i>
                    <div class="text-muted">{{ $card[0] }}</div>
                    <div class="fw-bold fs-5">{{ $card[1] }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Détail des remboursements</h5>
        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Crédit</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($details as $repayment)
                        <tr>
                            <td>{{ $repayment->user?->name }}</td>
                            <td>{{ $repayment->loanApplication?->reference }}</td>
                            <td>{{ number_format($repayment->amount, 2) }} CDF</td>
                            <td><span class="badge bg-{{ $repayment->status === 'confirmed' ? 'success' : 'warning' }}">{{ $repayment->status }}</span></td>
                            <td>{{ $repayment->created_at?->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Aucun remboursement ce mois.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
