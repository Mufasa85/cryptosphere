@extends('layouts.dashboard')

@section('title', 'Décaissements')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Décaissements</h2>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Client</th>
                        <th>Agent</th>
                        <th>Montant</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($disbursements as $loan)
                        <tr>
                            <td>{{ $loan->reference }}</td>
                            <td>{{ $loan->user?->name }}</td>
                            <td>{{ $loan->agent?->name ?? '-' }}</td>
                            <td>{{ number_format($loan->amount_approved, 2) }} CDF</td>
                            <td>{{ $loan->disbursed_at?->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Aucun décaissement.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $disbursements->links() }}
    </div>
</div>
@endsection
