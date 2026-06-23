@extends('layouts.dashboard')

@section('title', 'Mes remboursements')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Mes remboursements</h2>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Référence crédit</th>
                <th>Montant</th>
                <th>Méthode</th>
                <th>Numéro</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($repayments as $repayment)
                <tr>
                    <td>{{ $repayment->loanApplication->reference }}</td>
                    <td>{{ number_format($repayment->amount, 2) }} CDF</td>
                    <td>{{ $repayment->payment_method }}</td>
                    <td>{{ $repayment->mobile_number }}</td>
                    <td><span class="badge bg-{{ $repayment->status === 'confirmed' ? 'success' : 'warning' }}">{{ $repayment->status }}</span></td>
                    <td>{{ $repayment->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ route('client.repayments.receipt', $repayment) }}" class="btn btn-sm btn-outline-secondary" target="_blank">Reçu</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Aucun remboursement.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $repayments->links() }}
@endsection
