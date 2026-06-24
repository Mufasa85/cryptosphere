@extends('layouts.dashboard')

@section('title', 'Remboursements')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Remboursements</h2>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Crédit</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($repayments as $repayment)
                        <tr>
                            <td>{{ $repayment->id }}</td>
                            <td>{{ $repayment->user?->name }}</td>
                            <td>{{ $repayment->loanApplication?->reference ?? '-' }}</td>
                            <td>{{ number_format($repayment->amount, 2) }} CDF</td>
                            <td><span class="badge bg-{{ $repayment->status === 'confirmed' ? 'success' : 'warning' }}">{{ $repayment->status }}</span></td>
                            <td>{{ $repayment->created_at?->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">Aucun remboursement.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $repayments->links() }}
    </div>
</div>
@endsection
