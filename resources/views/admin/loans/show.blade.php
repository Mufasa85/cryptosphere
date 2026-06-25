@extends('layouts.dashboard')

@section('title', 'Détail crédit')

@section('dashboard-content')
<style>
    :root{
        --bg-primary:#050B12;
        --bg-secondary:#07131B;
        --card:#0D1823;
        --border:#142634;
        --text:#E9F2F7;
        --muted:#AEBBC6;
        --neon:#3DFF7A;
        --glow:#00C45A;
        --danger:#FF6B6B;
        --warning:#FFC107;
        --accent-blue:#49A7FF;
        --orange:#FF8A3D;
        --glass: rgba(13,24,35,.62);
    }

    .premium-page{
        background: radial-gradient(circle at top right, rgba(0,196,90,.10), transparent 40%),
                    radial-gradient(circle at bottom left, rgba(73,167,255,.06), transparent 45%);
        border: 1px solid var(--border);
        border-radius: 22px;
        padding: 18px;
        overflow:hidden;
    }

    .premium-header{
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        gap: 14px;
        flex-wrap:wrap;
        margin-bottom: 14px;
    }

    .premium-title{
        margin:0;
        font-weight: 950;
        letter-spacing: .04em;
        font-size: 1.55rem;
    }

    .premium-sub{
        margin-top: 10px;
        color: var(--muted);
        display:flex;
        flex-wrap:wrap;
        gap: 12px 18px;
        font-weight: 600;
    }

    .badge-status{
        display:inline-flex;
        align-items:center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 999px;
        font-weight: 950;
        letter-spacing:.02em;
        border:1px solid rgba(20,38,52,1);
        background: rgba(20,38,52,.25);
        box-shadow: 0 0 22px rgba(0,0,0,.18);
        white-space:nowrap;
    }

    .status-approved{ color: var(--neon); background: rgba(61,255,122,.10); border-color: rgba(61,255,122,.25); box-shadow: 0 0 28px rgba(0,196,90,.18); }
    .status-pending{ color: var(--warning); background: rgba(255,193,7,.12); border-color: rgba(255,193,7,.25); }
    .status-rejected{ color: var(--danger); background: rgba(255,107,107,.12); border-color: rgba(255,107,107,.25); box-shadow: 0 0 26px rgba(255,107,107,.10); }

    .stat-cards{
        display:grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin: 14px 0;
    }
    @media (max-width: 992px){ .stat-cards{ grid-template-columns: repeat(2, minmax(0,1fr)); } }
    @media (max-width: 576px){ .stat-cards{ grid-template-columns: 1fr; } }

    .stat-card{
        background: rgba(13,24,35,.45);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 14px;
        transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease;
        min-height: 92px;
    }

    .stat-card:hover{
        transform: translateY(-3px);
        border-color: rgba(61,255,122,.35);
        box-shadow: 0 0 22px rgba(0,196,90,.12);
    }

    .stat-row{ display:flex; align-items:center; justify-content:space-between; gap: 10px; }
    .stat-left{ display:flex; align-items:center; gap: 12px; }
    .stat-ico{
        width: 42px; height: 42px; border-radius: 14px;
        display:grid; place-items:center;
        background: rgba(61,255,122,.10);
        border: 1px solid rgba(61,255,122,.22);
        color: var(--neon);
        box-shadow: 0 0 18px rgba(0,196,90,.10);
        flex:0 0 auto;
    }
    .stat-label{ color: var(--muted); font-weight: 700; font-size: .85rem; margin:0; }
    .stat-value{ font-weight: 1000; font-size: 1.4rem; margin:0; color: var(--text); }

    .grid-2{
        display:grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }
    @media (max-width: 992px){ .grid-2{ grid-template-columns: 1fr; } }

    .glass-card{
        background: rgba(13,24,35,.45);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 14px;
    }

    .card-title{
        display:flex;
        align-items:center;
        gap: 10px;
        margin:0 0 10px;
        font-weight: 950;
        color: var(--text);
    }

    .card-title .dot{
        width: 12px; height: 12px; border-radius: 999px;
        background: rgba(61,255,122,.35);
        box-shadow: 0 0 18px rgba(0,196,90,.25);
    }

    .kv{
        display:grid;
        grid-template-columns: 1fr;
        gap: 10px;
    }
    .kv-row{
        display:flex;
        justify-content:space-between;
        gap: 12px;
        border-top: 1px solid rgba(20,38,52, .8);
        padding-top: 10px;
    }
    .kv-row:first-child{ border-top: none; padding-top:0; }

    .k{ color: var(--muted); font-weight: 700; }
    .v{ color: var(--text); font-weight: 800; text-align:right; }

    .alert-premium{
        border-radius: 16px;
        border: 1px solid rgba(255,107,107,.35);
        background: rgba(255,107,107,.12);
        color: var(--danger);
        padding: 12px;
        font-weight: 800;
        display:flex;
        align-items:flex-start;
        gap: 10px;
    }

    .timeline{
        display:flex;
        flex-direction:column;
        gap: 10px;
    }
    .t-item{
        display:flex;
        gap: 10px;
        align-items:flex-start;
        border: 1px solid rgba(20,38,52, .8);
        background: rgba(7,19,27,.25);
        border-radius: 16px;
        padding: 12px;
    }
    .t-ico{
        width: 34px; height: 34px; border-radius: 14px;
        display:grid; place-items:center;
        border: 1px solid rgba(20,38,52,1);
        background: rgba(13,24,35,.35);
        flex:0 0 auto;
        color: var(--muted);
    }
    .t-ico.ok{ color: var(--neon); border-color: rgba(61,255,122,.3); background: rgba(61,255,122,.08); }
    .t-ico.no{ color: var(--danger); border-color: rgba(255,107,107,.35); background: rgba(255,107,107,.08); }

    .actions-bar{
        display:flex;
        gap: 10px;
        flex-wrap:wrap;
        justify-content:flex-end;
        margin-top: 10px;
    }

    .btn-premium{
        border-radius: 14px;
        font-weight: 950;
        border: 1px solid var(--border);
        background: rgba(7,19,27,.28);
        color: var(--text);
        padding: 10px 14px;
        text-decoration:none;
        transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease, background .2s ease, color .2s ease;
        display:inline-flex;
        align-items:center;
        gap: 10px;
        cursor:pointer;
    }
    .btn-premium:hover{ transform: translateY(-3px); border-color: rgba(61,255,122,.35); box-shadow: 0 0 18px rgba(0,196,90,.14); background: rgba(61,255,122,.06); }

    .btn-approve{ color: var(--neon); border-color: rgba(61,255,122,.28); background: rgba(61,255,122,.10); }
    .btn-reject{ color: var(--danger); border-color: rgba(255,107,107,.35); background: rgba(255,107,107,.12); }
    .btn-outline{
        background: transparent;
        border:1px solid var(--border);
        color: var(--muted);
    }
    .btn-outline:hover{ color: var(--neon); border-color: rgba(61,255,122,.35); background: rgba(61,255,122,.06); }

    .muted-small{ color: var(--muted); font-size: .9rem; font-weight: 700; }

    @media (max-width: 576px){
        .premium-header{ flex-direction:column; align-items:flex-start; }
        .actions-bar{ justify-content:flex-start; }
    }
</style>

@php
    $loanId = $loan->reference;

    // Status badge mapping requested
    $status = (string) ($loan->status ?? '');
    $statusKey = match($status){
        'approved' => 'approved',
        'disbursed' => 'approved',
        'submitted' => 'pending',
        'under_review' => 'pending',
        'rejected' => 'rejected',
        default => $status === 'rejected' ? 'rejected' : 'pending',
    };

    $statusLabel = match($statusKey){
        'approved' => 'Approuvé',
        'pending' => 'En attente',
        'rejected' => 'Rejeté',
        default => 'En attente',
    };

    $badgeIcon = match($statusKey){
        'approved' => '🟢',
        'pending' => '🟡',
        'rejected' => '🔴',
        default => '🟡',
    };

    $statusClass = match($statusKey){
        'approved' => 'status-approved',
        'pending' => 'status-pending',
        'rejected' => 'status-rejected',
        default => 'status-pending',
    };

    $createdAt = optional($loan->created_at)->format('d/m/Y');
    $agentName = $loan->agent?->name ?? '-';
    $clientName = $loan->user?->name ?? '-';

    $purpose = $loan->purpose ?? '-';
    $rejectionReason = $loan->rejection_reason ?? null;

    // Product object if exists
    $loanType = $loan->loanProduct?->name ?? ($loan->product_type ?? '');
    $loanType = $loanType ?: '-';

    $amountRequested = (float) ($loan->amount_requested ?? 0);
    $amountApproved = (float) ($loan->amount_approved ?? 0);
    $durationMonths = (int) ($loan->duration_months ?? 0);
    $interestRate = (float) ($loan->interest_rate ?? 0);

    // Due date best effort
    $dueDate = optional($loan->maturity_date ?? $loan->due_date ?? null)->format('d/m/Y');
@endphp

<div class="premium-page">
    <div class="premium-header">
        <div>
            <div class="premium-title">{{ $loanId }}</div>
            <div class="premium-sub">
                <span><span class="muted-small">Numéro</span>: <b>{{ $loanId }}</b></span>
                <span><span class="muted-small">Date</span>: <b>{{ $createdAt ?? '-' }}</b></span>
                <span><span class="muted-small">Agent</span>: <b>{{ $agentName }}</b></span>
                <span><span class="muted-small">Client</span>: <b>{{ $clientName }}</b></span>
            </div>
        </div>

        <div class="badge-status {{ $statusClass }}">
            <span style="font-size:1.1rem;">{{ $badgeIcon }}</span>
            {{ $statusLabel }}
        </div>

        <div class="actions-bar">
            {{-- Actions: route names are best-effort (adjust if your routes differ) --}}
            <a href="{{ route('admin.loans.show', $loan) }}" class="btn-premium btn-outline" title="Modifier">✏️ Modifier</a>
        </div>
    </div>

    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-row">
                <div class="stat-left">
                    <div class="stat-ico"><i class="bi bi-cash-stack"></i></div>
                    <div>
                        <p class="stat-label">Montant demandé</p>
                        <p class="stat-value">{{ number_format($amountRequested, 0, ',', ' ') }} CDF</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-row">
                <div class="stat-left">
                    <div class="stat-ico" style="background:rgba(73,167,255,.10);border-color:rgba(73,167,255,.22);color:var(--accent-blue)"><i class="bi bi-check2-circle"></i></div>
                    <div>
                        <p class="stat-label">Montant approuvé</p>
                        <p class="stat-value">{{ number_format($amountApproved, 0, ',', ' ') }} CDF</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-row">
                <div class="stat-left">
                    <div class="stat-ico" style="background:rgba(255,193,7,.10);border-color:rgba(255,193,7,.22);color:var(--warning)"><i class="bi bi-clock"></i></div>
                    <div>
                        <p class="stat-label">Durée</p>
                        <p class="stat-value">{{ $durationMonths }} mois</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-row">
                <div class="stat-left">
                    <div class="stat-ico" style="background:rgba(61,255,122,.10);border-color:rgba(0,196,90,.22);color:var(--neon)"><i class="bi bi-percent"></i></div>
                    <div>
                        <p class="stat-label">Taux d'intérêt</p>
                        <p class="stat-value">{{ $interestRate }} %</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid-2">
        <div class="glass-card">
            <div class="card-title"><span class="dot"></span> Client</div>
            <div class="kv">
                <div class="kv-row"><div class="k">Nom</div><div class="v">{{ $clientName }}</div></div>
                <div class="kv-row"><div class="k">Email</div><div class="v">{{ $loan->user->email ?? '-' }}</div></div>
                <div class="kv-row"><div class="k">Téléphone</div><div class="v">{{ $loan->user->phone ?? '-' }}</div></div>
                <div class="kv-row"><div class="k">Date d'inscription</div><div class="v">{{ optional($loan->user->created_at)->format('d/m/Y') ?? '-' }}</div></div>
            </div>
        </div>

        <div class="glass-card">
            <div class="card-title"><span class="dot"></span> Détails du crédit</div>
            <div class="kv">
                <div class="kv-row"><div class="k">Type de prêt</div><div class="v">{{ $loanType }}</div></div>
                <div class="kv-row"><div class="k">Montant demandé</div><div class="v">{{ number_format($amountRequested, 0, ',', ' ') }} CDF</div></div>
                <div class="kv-row"><div class="k">Durée</div><div class="v">{{ $durationMonths }} mois</div></div>
                <div class="kv-row"><div class="k">Taux</div><div class="v">{{ $interestRate }} %</div></div>
                <div class="kv-row"><div class="k">Date d'échéance</div><div class="v">{{ $dueDate ?? '-' }}</div></div>
            </div>
        </div>

        <div class="glass-card">
            <div class="card-title"><span class="dot"></span> Objet du prêt</div>
            <div class="muted-small">{{ $purpose }}</div>
            <div style="margin-top:10px; color:var(--muted); font-weight:800;">
                Gestion des produits
            </div>
        </div>

        <div class="glass-card">
            <div class="card-title"><span class="dot" style="background:rgba(255,107,107,.35); box-shadow:0 0 18px rgba(255,107,107,.25)"></span> Motif du rejet</div>
            @if($rejectionReason)
                <div class="alert-premium">
                    <div style="font-size:1.2rem;"></div>
                    <div>
                        <div style="font-weight:1000; margin-bottom:6px;">Non conforme aux critères</div>
                        <div style="color:var(--muted); font-weight:800;">{{ $rejectionReason }}</div>
                    </div>
                </div>
            @else
                <div class="muted-small">Aucun motif de rejet.</div>
            @endif
        </div>

        <div class="glass-card" style="grid-column: 1 / -1;">
            <div class="card-title"><span class="dot"></span> Timeline</div>
            <div class="timeline">
                <div class="t-item">
                    <div class="t-ico ok">✓</div>
                    <div>
                        <div style="font-weight:950;">Demande créée</div>
                        <div class="muted-small">{{ optional($loan->created_at)->format('d/m/Y') ?? '-' }}</div>
                    </div>
                </div>
                <div class="t-item">
                    <div class="t-ico ok">✓</div>
                    <div>
                        <div style="font-weight:950;">Décision administrateur</div>
                        <div class="muted-small">{{ $statusLabel }}</div>
                    </div>
                </div>
                <div class="t-item" style="border-color: rgba(255,107,107,.28); background: rgba(255,107,107,.05);">
                    <div class="t-ico no">✗</div>
                    <div>
                        <div style="font-weight:950;">Crédit rejeté</div>
                        <div class="muted-small">{{ $statusKey === 'rejected' ? 'Oui' : 'Non' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

