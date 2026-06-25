@extends('layouts.dashboard')

@section('title', 'Rapport des crédits')

@section('dashboard-content')
    @include('admin.reports._premium_layout')

    <div class="reports-wrap">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
            <div>
                <div class="reports-title">Rapport des crédits</div>
                <div style="color: var(--muted); font-weight:700; margin-top:6px;">Vue détaillée & filtres fintech</div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.reports.credits', ['format' => 'csv'] + request()->query()) }}" class="btn-premium" title="Export Excel" style="background:transparent; border:1px solid rgba(20,38,52,1);">
                    <i class="bi bi-file-spreadsheet"></i> Export Excel
                </a>
                <a href="{{ route('admin.reports.index', ['format' => 'pdf']) }}" class="btn-premium" title="Export PDF" style="background:transparent; border:1px solid rgba(20,38,52,1);">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
            </div>
        </div>

        <div class="stat-grid">
            @foreach([
                ['Total', $stats['total']],
                ['Décaissés', $stats['disbursed']],
                ['Remboursé', number_format($stats['repaid'], 2) . ' CDF'],
                ['Encours', number_format($stats['outstanding'], 2) . ' CDF'],
            ] as $card)
                <div class="stat-item">
                    <p class="stat-label">{{ $card[0] }}</p>
                    <p class="stat-value">{{ $card[1] }}</p>
                </div>
            @endforeach
        </div>

        <div class="glass-card">
            <form method="GET" class="row g-3 mb-3 filter-row">
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
                <table class="table-premium">
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
                                <td><span style="font-weight:950; color:var(--text);">{{ $loan->reference }}</span></td>
                                <td>{{ $loan->user?->name }}</td>
                                <td>{{ number_format($loan->amount_requested, 2) }} CDF</td>
                                <td>
                                    @php
                                        $st = (string) ($loan->status ?? '');
                                        $pillClass = match($st){
                                            'submitted' => 'submitted',
                                            'under_review' => 'under_review',
                                            'approved','disbursed' => 'approved',
                                            'rejected' => 'rejected',
                                            default => 'submitted'
                                        };
                                    @endphp
                                    <span class="status-pill {{ $pillClass }}">{{ $st }}</span>
                                </td>
                                <td>{{ $loan->created_at?->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center" style="padding:22px 0; color:var(--muted);">Aucun crédit.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">{{ $loans->links() }}</div>
        </div>
    </div>
@endsection

