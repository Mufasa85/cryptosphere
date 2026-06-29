@extends('layouts.dashboard')

@section('title', 'Tableau de bord client')

@section('dashboard-content')
@include('layouts.partials.agent-table-styles')

<div class="at-root">

    <div class="at-page-header">
        <div>
            <h1 class="at-page-title">Tableau de bord</h1>
            <p class="at-page-subtitle">Bienvenue, {{ auth()->user()->name }}</p>
        </div>
        <a href="{{ route('client.loans.create') }}" class="at-btn at-btn-primary">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nouvelle demande
        </a>
    </div>

    <div class="at-stat-grid">
        <div class="at-stat-card">
            <div class="at-stat-icon at-stat-icon-green">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div>
                <div class="at-stat-label">Crédits en cours</div>
                <div class="at-stat-value">{{ number_format($outstanding, 2) }} <span style="font-size:.75rem;color:var(--muted);">CDF</span></div>
            </div>
        </div>
        <div class="at-stat-card">
            <div class="at-stat-icon at-stat-icon-blue">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <div class="at-stat-label">Demandes</div>
                <div class="at-stat-value">{{ $loans->count() }}</div>
            </div>
        </div>
        <div class="at-stat-card">
            <div class="at-stat-icon at-stat-icon-orange">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            </div>
            <div>
                <div class="at-stat-label">Remboursements</div>
                <div class="at-stat-value">{{ $repayments->count() }}</div>
            </div>
        </div>
    </div>

    <div class="at-card">
        <div class="at-card-header">Dernières demandes</div>
        <div class="at-table-wrap">
            <table class="at-table">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        @php
                            $badges = [
                                'submitted'    => ['at-badge-blue',   'Soumis'],
                                'under_review' => ['at-badge-orange', 'En cours'],
                                'approved'     => ['at-badge-green',  'Approuvé'],
                                'rejected'     => ['at-badge-red',    'Refusé'],
                                'disbursed'    => ['at-badge-purple', 'Décaissé'],
                                'running'      => ['at-badge-green',  'Actif'],
                                'closed'       => ['at-badge-gray',   'Clôturé'],
                            ];
                            [$cls, $lbl] = $badges[$loan->status] ?? ['at-badge-gray', $loan->status];
                        @endphp
                        <tr>
                            <td><span class="at-ref">{{ $loan->reference }}</span></td>
                            <td style="font-weight:600;color:var(--text);">{{ number_format($loan->amount_requested, 2) }} <span style="color:var(--muted);font-size:.78rem;">CDF</span></td>
                            <td><span class="at-badge {{ $cls }}">{{ $lbl }}</span></td>
                            <td style="color:var(--muted);font-size:.82rem;">{{ $loan->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('client.loans.show', $loan) }}" class="at-btn-icon at-btn-icon-blue" title="Voir">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">
                            <div class="at-empty">
                                <svg width="48" height="48" fill="none" stroke="#142634" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/></svg>
                                <p>Aucune demande pour le moment.</p>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
