@extends('layouts.dashboard')

@section('title', 'Détail du crédit')

@section('dashboard-content')
@include('layouts.partials.agent-table-styles')

<div class="at-root">

    <div class="at-page-header">
        <div>
            <h1 class="at-page-title">Crédit <span class="at-ref">{{ $loan->reference }}</span></h1>
            <p class="at-page-subtitle">Détails de votre dossier de crédit</p>
        </div>
        <div style="display:flex;gap:10px;align-items:center;">
            @if(in_array($loan->status, ['disbursed', 'running']))
                <a href="{{ route('client.repayments.create', $loan) }}" class="at-btn at-btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    Rembourser
                </a>
            @endif
            <a href="{{ route('client.loans.index') }}" class="at-btn at-btn-ghost at-btn-sm">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Retour
            </a>
        </div>
    </div>

    {{-- Info card --}}
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
    <div class="at-card" style="margin-bottom:20px;padding:24px 28px;">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:20px;">
            <div>
                <div class="at-stat-label" style="margin-bottom:6px;">Montant demandé</div>
                <div style="font-weight:700;font-size:1.1rem;color:var(--text);">{{ number_format($loan->amount_requested, 2) }} <span style="font-size:.78rem;color:var(--muted);">CDF</span></div>
            </div>
            <div>
                <div class="at-stat-label" style="margin-bottom:6px;">Montant approuvé</div>
                <div style="font-weight:700;font-size:1.1rem;color:var(--neon);">{{ $loan->amount_approved ? number_format($loan->amount_approved, 2).' CDF' : '—' }}</div>
            </div>
            <div>
                <div class="at-stat-label" style="margin-bottom:6px;">Durée</div>
                <div style="color:var(--text);font-size:.95rem;">{{ $loan->duration_months }} mois</div>
            </div>
            <div>
                <div class="at-stat-label" style="margin-bottom:6px;">Taux d'intérêt</div>
                <div style="color:var(--text);font-size:.95rem;">{{ $loan->interest_rate }} %</div>
            </div>
            <div>
                <div class="at-stat-label" style="margin-bottom:6px;">Statut</div>
                <span class="at-badge {{ $cls }}">{{ $lbl }}</span>
            </div>
            <div>
                <div class="at-stat-label" style="margin-bottom:6px;">Date de soumission</div>
                <div style="color:var(--muted);font-size:.88rem;">{{ $loan->created_at->format('d/m/Y') }}</div>
            </div>
        </div>
        @if($loan->purpose)
            <div style="margin-top:20px;padding-top:18px;border-top:1px solid var(--border);">
                <div class="at-stat-label" style="margin-bottom:6px;">Motif</div>
                <div style="color:var(--text);font-size:.9rem;line-height:1.6;">{{ $loan->purpose }}</div>
            </div>
        @endif
        @if($loan->rejection_reason)
            <div style="margin-top:16px;padding:14px 16px;background:rgba(255,107,107,.08);border:1px solid rgba(255,107,107,.2);border-radius:10px;">
                <div style="color:var(--danger);font-size:.82rem;font-weight:600;margin-bottom:4px;text-transform:uppercase;letter-spacing:.5px;">Motif du rejet</div>
                <div style="color:var(--text);font-size:.9rem;">{{ $loan->rejection_reason }}</div>
            </div>
        @endif
    </div>

    {{-- Schedule table --}}
    @if($loan->schedules->isNotEmpty())
        <div class="at-card">
            <div class="at-card-header">Échéancier de remboursement</div>
            <div class="at-table-wrap">
                <table class="at-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Échéance</th>
                            <th>Principal</th>
                            <th>Intérêt</th>
                            <th>Total</th>
                            <th>Payé</th>
                            <th>Reste</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loan->schedules as $schedule)
                            @php
                                $sBadges=['paid'=>['at-badge-green','Payé'],'overdue'=>['at-badge-red','En retard'],'partial'=>['at-badge-orange','Partiel'],'pending'=>['at-badge-gray','En attente']];
                                [$sc,$sl]=$sBadges[$schedule->status]??['at-badge-gray',$schedule->status];
                            @endphp
                            <tr>
                                <td style="color:var(--muted);font-weight:600;">{{ $schedule->installment_number }}</td>
                                <td style="color:var(--text);">{{ $schedule->due_date->format('d/m/Y') }}</td>
                                <td style="color:var(--text);">{{ number_format($schedule->principal_amount, 2) }}</td>
                                <td style="color:var(--muted);">{{ number_format($schedule->interest_amount, 2) }}</td>
                                <td style="font-weight:600;color:var(--text);">{{ number_format($schedule->total_amount, 2) }}</td>
                                <td style="color:var(--neon);">{{ number_format($schedule->paid_amount, 2) }}</td>
                                <td style="color:{{ $schedule->remaining_amount > 0 ? 'var(--warning)' : 'var(--muted)' }};font-weight:600;">{{ number_format($schedule->remaining_amount, 2) }}</td>
                                <td><span class="at-badge {{ $sc }}">{{ $sl }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
@endsection
