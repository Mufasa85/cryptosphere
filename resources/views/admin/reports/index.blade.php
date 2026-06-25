@extends('layouts.dashboard')

@section('title', 'Rapports')

@section('dashboard-content')
    @include('admin.reports._premium_layout')

    <div class="reports-wrap">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
            <div>
                <div class="reports-title">Rapports</div>
                <div style="color: var(--muted); font-weight:700; margin-top:6px;">Vue analytique fintech</div>
            </div>
            <a href="?format=pdf" class="btn-premium" title="Télécharger PDF">
                <i class="bi bi-file-earmark-pdf"></i>
                Télécharger PDF
            </a>
        </div>

        <div class="stat-grid">
            @foreach([
                ['Total décaissé', number_format($stats['total_disbursed'], 2) . ' CDF'],
                ['Total remboursé', number_format($stats['repayments_total'], 2) . ' CDF'],
                ['Transactions réussies', $stats['transactions_success']],
                ['Transactions échouées', $stats['transactions_failed']],
            ] as $card)
                <div class="stat-item">
                    <p class="stat-label">{{ $card[0] }}</p>
                    <p class="stat-value">{{ $card[1] }}</p>
                </div>
            @endforeach
        </div>

        <div class="glass-card">
            <div class="card-title" style="margin-bottom:12px;">
                <span class="dot"></span> Volume mensuel
            </div>

            <div class="table-responsive">
                <table class="table-premium">
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
                            <tr><td colspan="3" class="text-center" style="padding:22px 0; color: var(--muted);">Aucune donnée.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

