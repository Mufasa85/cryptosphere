@extends('layouts.dashboard')

@section('title', 'Rapport mensuel')

@section('dashboard-content')
@include('layouts.partials.agent-table-styles')

<div class="at-root">

    <div class="at-page-header">
        <div>
            <h1 class="at-page-title">Rapport mensuel</h1>
            <p class="at-page-subtitle">Activité de {{ \Carbon\Carbon::parse($month.'-01')->translatedFormat('F Y') }}</p>
        </div>
    </div>

    <div class="at-filter-card" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
        <form method="GET" style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;width:100%;">
            <div class="at-search-wrap" style="max-width:220px;">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#475569;pointer-events:none;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <input type="month" name="month" class="at-search" style="padding-left:38px;" value="{{ old('month', $month) }}">
            </div>
            <button type="submit" class="at-btn at-btn-primary at-btn-sm">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                Afficher
            </button>
        </form>
    </div>

    <div class="at-stat-grid">
        <div class="at-stat-card">
            <div class="at-stat-icon at-stat-icon-green">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div><div class="at-stat-label">Remboursements</div><div class="at-stat-value">{{ number_format($repayments, 2) }} CDF</div></div>
        </div>
        <div class="at-stat-card">
            <div class="at-stat-icon at-stat-icon-blue">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
            </div>
            <div><div class="at-stat-label">Décaissements</div><div class="at-stat-value">{{ number_format($disbursements, 2) }} CDF</div></div>
        </div>
        <div class="at-stat-card">
            <div class="at-stat-icon at-stat-icon-orange">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div><div class="at-stat-label">Nouvelles demandes</div><div class="at-stat-value">{{ $submissions }}</div></div>
        </div>
    </div>

    <div class="at-card">
        <div class="at-card-header">Détail des remboursements</div>
        <div class="at-table-wrap">
            <table class="at-table">
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
                        @php
                            $badges=['confirmed'=>['at-badge-green','Confirmé'],'pending'=>['at-badge-orange','En attente'],'processing'=>['at-badge-blue','En cours'],'failed'=>['at-badge-red','Échoué']];
                            [$cls,$lbl]=$badges[$repayment->status]??['at-badge-gray',$repayment->status];
                        @endphp
                        <tr>
                            <td>
                                <div class="at-user-cell">
                                    <div class="at-avatar">{{ strtoupper(substr($repayment->user?->name??'?',0,1)) }}</div>
                                    <div class="at-user-name">{{ $repayment->user?->name ?? '—' }}</div>
                                </div>
                            </td>
                            <td><span class="at-ref">{{ $repayment->loanApplication?->reference ?? '—' }}</span></td>
                            <td style="font-weight:600;color:var(--text);">{{ number_format($repayment->amount,2) }} <span style="color:var(--muted);font-size:.78rem;">CDF</span></td>
                            <td><span class="at-badge {{ $cls }}">{{ $lbl }}</span></td>
                            <td style="color:var(--muted);">{{ $repayment->created_at?->format('d/m/Y') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5">
                            <div class="at-empty">
                                <svg width="44" height="44" fill="none" stroke="#334155" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                <p>Aucun remboursement ce mois.</p>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
