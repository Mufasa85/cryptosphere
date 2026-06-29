@extends('layouts.dashboard')

@section('title', 'Détail client')

@section('dashboard-content')
@include('layouts.partials.agent-table-styles')

<div class="at-root">

    {{-- Header --}}
    <div class="at-page-header">
        <div style="display:flex;align-items:center;gap:16px;">
            <div class="at-avatar" style="width:52px;height:52px;font-size:1.1rem;">
                {{ strtoupper(substr($client->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="at-page-title">{{ $client->name }}</h1>
                <p class="at-page-subtitle">Fiche client — {{ $client->loanApplications->count() }} demande(s)</p>
            </div>
        </div>
        <a href="{{ route('agent.clients.index') }}" class="at-btn at-btn-ghost at-btn-sm">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Retour
        </a>
    </div>

    {{-- Profile card --}}
    <div class="at-card" style="margin-bottom:20px;padding:24px 28px;">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;">
            <div>
                <div class="at-stat-label" style="margin-bottom:6px;">Email</div>
                <div style="color:var(--text);font-size:.9rem;display:flex;align-items:center;gap:7px;">
                    <svg width="14" height="14" fill="none" stroke="var(--neon)" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    {{ $client->email }}
                </div>
            </div>
            <div>
                <div class="at-stat-label" style="margin-bottom:6px;">Téléphone</div>
                <div style="color:var(--text);font-size:.9rem;display:flex;align-items:center;gap:7px;">
                    <svg width="14" height="14" fill="none" stroke="var(--neon)" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.53 2 2 0 0 1 3.6 1.35h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9a16 16 0 0 0 6 6l.95-1.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21.73 15z"/></svg>
                    {{ $client->phone ?? '—' }}
                </div>
            </div>
            <div>
                <div class="at-stat-label" style="margin-bottom:6px;">Statut du compte</div>
                <div>
                    @if($client->is_active)
                        <span class="at-badge at-badge-green">Actif</span>
                    @else
                        <span class="at-badge at-badge-red">Inactif</span>
                    @endif
                </div>
            </div>
            <div>
                <div class="at-stat-label" style="margin-bottom:6px;">Membre depuis</div>
                <div style="color:var(--text);font-size:.9rem;">{{ $client->created_at->format('d/m/Y') }}</div>
            </div>
        </div>
    </div>

    {{-- Loans table --}}
    <div class="at-card">
        <div class="at-card-header">Demandes de crédit</div>
        <div class="at-table-wrap">
            <table class="at-table">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Montant demandé</th>
                        <th>Montant approuvé</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($client->loanApplications as $loan)
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
                            <td style="font-weight:600;color:var(--text);">
                                {{ number_format($loan->amount_requested, 2) }} <span style="color:var(--muted);font-size:.78rem;">CDF</span>
                            </td>
                            <td style="color:var(--muted);">
                                {{ $loan->amount_approved ? number_format($loan->amount_approved, 2).' CDF' : '—' }}
                            </td>
                            <td><span class="at-badge {{ $cls }}">{{ $lbl }}</span></td>
                            <td style="color:var(--muted);font-size:.82rem;">{{ $loan->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('agent.loans.show', $loan) }}" class="at-btn-icon at-btn-icon-blue" title="Voir le dossier">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">
                            <div class="at-empty">
                                <svg width="48" height="48" fill="none" stroke="#142634" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2z"/></svg>
                                <p>Aucune demande de crédit pour ce client.</p>
                            </div>
                        </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
