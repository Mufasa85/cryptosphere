@extends('layouts.dashboard')

@section('title', 'Rapports')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Rapports</h2>
    <a href="?format=pdf" class="btn btn-danger">Télécharger PDF</a>
</div>

<div class="row mb-4">
    @foreach([
        ['Total décaissé', number_format($stats['total_disbursed'], 2) . ' CDF'],
        ['Total remboursé', number_format($stats['repayments_total'], 2) . ' CDF'],
        ['Transactions réussies', $stats['transactions_success']],
        ['Transactions échouées', $stats['transactions_failed']],
    ] as $card)
        <div class="col-md-3 mb-3">
            <div class="stat-card text-center">
                <div class="stat-label">{{ $card[0] }}</div>
                <div class="stat-value">{{ $card[1] }}</div>
            </div>
        </div>
    @endforeach
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Volume mensuel</h5>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Mois</th>
                        <th>Nombre</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monthly as $row)
                        <tr>
                            <td>{{ $row['month'] }}</td>
                            <td>{{ $row['count'] }}</td>
                            <td>{{ number_format($row['amount'], 2) }} CDF</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">Aucune donnée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
