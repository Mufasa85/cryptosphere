@extends('layouts.dashboard')

@section('title', 'Tableau de bord agent')

@section('dashboard-content')
@include('layouts.partials.agent-table-styles')

<div class="at-root">

    <div class="at-page-header">
        <div>
            <h1 class="at-page-title">Tableau de bord</h1>
            <p class="at-page-subtitle">Bienvenue, {{ auth()->user()->name }}</p>
        </div>
    </div>

    {{-- Stat cards --}}
    <div class="at-stat-grid">
        <div class="at-stat-card">
            <div class="at-stat-icon at-stat-icon-orange">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div>
                <div class="at-stat-label">Dossiers en attente</div>
                <div class="at-stat-value">{{ $pending }}</div>
            </div>
        </div>
        <div class="at-stat-card">
            <div class="at-stat-icon at-stat-icon-blue">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <div class="at-stat-label">Nouvelles soumissions</div>
                <div class="at-stat-value">{{ $toReview }}</div>
            </div>
        </div>
    </div>

    {{-- Recent loans table --}}
    <div class="at-card">
        <div class="at-card-header">Dernières demandes</div>
        <div class="at-table-wrap">
            <table class="at-table">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Client</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent as $loan)
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
                            <td>
                                <div class="at-user-cell">
                                    <div class="at-avatar">{{ strtoupper(substr($loan->user->name, 0, 1)) }}</div>
                                    <div class="at-user-name">{{ $loan->user->name }}</div>
                                </div>
                            </td>
                            <td style="font-weight:600;color:var(--text);">{{ number_format($loan->amount_requested, 2) }} <span style="color:var(--muted);font-size:.78rem;">CDF</span></td>
                            <td><span class="at-badge {{ $cls }}">{{ $lbl }}</span></td>
                            <td style="color:var(--muted);font-size:.82rem;">{{ $loan->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('agent.validations.show', $loan) }}" class="at-btn-icon at-btn-icon-blue" title="Instruire">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">
                            <div class="at-empty">
                                <svg width="48" height="48" fill="none" stroke="#142634" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/></svg>
                                <p>Aucune demande récente.</p>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
