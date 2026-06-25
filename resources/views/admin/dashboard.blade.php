@extends('layouts.dashboard')

@section('title', 'Tableau de bord administrateur')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Tableau de bord administrateur</h2>
</div>

<div class="row mb-4">
    @foreach([
        ['Utilisateurs', $stats['users_count'], 'people'],
        ['Clients', $stats['clients_count'], 'people-fill'],
        ['Agents', $stats['agents_count'], 'briefcase'],
        ['Crédits', $stats['loans_count'], 'cash-stack'],
        ['Décaissé', number_format($stats['total_disbursed'], 2) . ' CDF', 'bank'],
        ['Remboursements', number_format($stats['repayments_total'], 2) . ' CDF', 'credit-card'],
    ] as $card)
        <div class="col-md-4 col-lg-2 mb-3">
            <div class="stat-card text-center">
                <i class="bi bi-{{ $card[2] }} fs-1" style="color:#3DFF7A;"></i>
                <div class="stat-label mt-2">{{ $card[0] }}</div>
                <div class="stat-value" style="font-size:1.2rem;">{{ $card[1] }}</div>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Volume mensuel</h5>
                 <div style="position: relative; height: 220px; width: 100%;">
                   <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Répartition par statut</h5>
                <div style="position: relative; height: 220px; width: 100%;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const monthly = @json($monthly);
    const status = @json($status);

    const chartColor = '#E9F2F7';
    const gridColor = 'rgba(174, 187, 198, 0.15)';

    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: monthly.map(m => m.month),
            datasets: [{
                label: 'Montant demandé',
                data: monthly.map(m => m.amount),
                backgroundColor: '#3DFF7A',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { labels: { color: chartColor } }
            },
            scales: {
                x: {
                    ticks: { color: chartColor },
                    grid: { color: gridColor }
                },
                y: {
                    ticks: { color: chartColor },
                    grid: { color: gridColor }
                }
            }
        }
    });

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(status),
            datasets: [{
                data: Object.values(status),
                backgroundColor: ['#3DFF7A', '#49A7FF', '#A6FF5B', '#FF6B6B', '#FFC107'],
                borderColor: '#0D1823',
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { labels: { color: chartColor } }
            }
        }
    });
</script>
@endpush
