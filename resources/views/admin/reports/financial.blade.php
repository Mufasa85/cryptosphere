@extends('layouts.dashboard')

@section('title', 'Rapport financier')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom d-flex justify-content-between align-items-center">
    <h2>Rapport financier</h2>
    <a href="{{ route('admin.reports.financial', ['format' => 'csv'] + request()->query()) }}" class="btn btn-outline-secondary">Export Excel</a>
</div>

<div class="row mb-4">
    @foreach([
        ['Décaissé', number_format($disbursed, 2) . ' CDF', 'bank'],
        ['Remboursé', number_format($repaid, 2) . ' CDF', 'credit-card'],
        ['Intérêts', number_format($interest, 2) . ' CDF', 'graph-up'],
        ['Pénalités', number_format($penalties, 2) . ' CDF', 'exclamation-circle'],
        ['Revenus', number_format($revenue, 2) . ' CDF', 'cash-stack'],
        ['Encours', number_format($outstanding, 2) . ' CDF', 'wallet'],
    ] as $card)
        <div class="col-md-4 col-lg-2 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-{{ $card[2] }} fs-1" style="color:#3DFF7A;"></i>
                    <div class="text-muted">{{ $card[0] }}</div>
                    <div class="fw-bold">{{ $card[1] }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Décaissements mensuels</h5>
        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Mois</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monthly as $row)
                        <tr>
                            <td>{{ $row->month }}</td>
                            <td>{{ number_format($row->amount, 2) }} CDF</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center">Aucune donnée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
