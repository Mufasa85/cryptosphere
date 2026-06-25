@extends('layouts.dashboard')

@section('title', 'Détail utilisateur')

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

    .premium-title{ margin:0; font-weight:950; letter-spacing:.04em; font-size: 1.55rem; }

    .premium-sub{ margin-top:10px; color:var(--muted); display:flex; flex-wrap:wrap; gap: 12px 18px; font-weight:600; }

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

    .status-active{ color: var(--neon); background: rgba(61,255,122,.10); border-color: rgba(61,255,122,.25); box-shadow: 0 0 28px rgba(0,196,90,.18); }
    .status-inactive{ color: var(--danger); background: rgba(255,107,107,.12); border-color: rgba(255,107,107,.25); }

    .role-badge{
        display:inline-flex; align-items:center; gap: 8px;
        padding: 10px 14px; border-radius: 999px;
        border: 1px solid rgba(20,38,52,1);
        background: rgba(13,24,35,.35);
        font-weight:950;
        white-space:nowrap;
    }
    .role-admin{ color: var(--neon); box-shadow:0 0 22px rgba(0,196,90,.12); border-color: rgba(61,255,122,.28); background: rgba(61,255,122,.10); }
    .role-agent{ color: var(--accent-blue); border-color: rgba(73,167,255,.28); background: rgba(73,167,255,.10); }
    .role-client{ color: var(--text); border-color: rgba(61,255,122,.18); background: rgba(20,38,52,.25); }

    .avatar-lg{
        width: 52px; height: 52px; border-radius: 999px;
        background: linear-gradient(135deg, rgba(61,255,122,.18), rgba(0,196,90,.10));
        border: 1px solid rgba(61,255,122,.22);
        color: var(--neon);
        display:flex; align-items:center; justify-content:center;
        font-weight: 1000;
        box-shadow: 0 0 22px rgba(0,196,90,.16);
        flex: 0 0 auto;
    }

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

    .dot{ width: 12px; height: 12px; border-radius: 999px; background: rgba(61,255,122,.35); box-shadow: 0 0 18px rgba(0,196,90,.25); }

    .kv{ display:grid; grid-template-columns: 1fr; gap: 10px; }
    .kv-row{ display:flex; justify-content:space-between; gap: 12px; border-top: 1px solid rgba(20,38,52,.8); padding-top: 10px; }
    .kv-row:first-child{ border-top:none; padding-top:0; }
    .k{ color: var(--muted); font-weight:700; }
    .v{ color: var(--text); font-weight:850; text-align:right; max-width: 60%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }

    .stat-cards{ display:grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; margin-top: 12px; }
    @media (max-width: 992px){ .stat-cards{ grid-template-columns: repeat(2, minmax(0, 1fr)); } }
    @media (max-width: 576px){ .stat-cards{ grid-template-columns: 1fr; } }

    .stat-card{
        background: rgba(13,24,35,.45);
        border: 1px solid var(--border);
        border-radius: 18px;
        padding: 14px;
        transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease;
        min-height: 92px;
    }
    .stat-card:hover{ transform: translateY(-3px); border-color: rgba(61,255,122,.35); box-shadow: 0 0 22px rgba(0,196,90,.12); }

    .stat-row{ display:flex; align-items:center; gap: 12px; justify-content:flex-start; }
    .stat-ico{ width: 42px; height: 42px; border-radius: 14px; display:grid; place-items:center; background: rgba(61,255,122,.10); border: 1px solid rgba(61,255,122,.22); color: var(--neon); box-shadow:0 0 18px rgba(0,196,90,.10); flex:0 0 auto; }
    .stat-label{ color: var(--muted); font-weight: 700; font-size: .85rem; margin:0; }
    .stat-value{ color: var(--text); font-weight: 1000; font-size: 1.4rem; margin:0; }

    .table-premium{ width:100%; border-collapse:separate; border-spacing:0; border-radius:18px; border:1px solid var(--border); background:rgba(13,24,35,.35); overflow:hidden; }
    .table-premium thead th{ background: rgba(7,19,27,.45); border-bottom:1px solid rgba(20,38,52,1); color:var(--muted); font-size:.78rem; font-weight:900; letter-spacing:.06em; text-transform:uppercase; padding:14px 14px; }
    .table-premium tbody td{ padding:12px 14px; border-top:1px solid rgba(20,38,52,.7); color:var(--text); vertical-align:middle; }
    .table-premium tbody tr:hover td{ background: rgba(61,255,122,.05); }

    .status-pill{ display:inline-flex; align-items:center; gap:8px; padding:7px 11px; border-radius:999px; font-weight:950; font-size:.82rem; border:1px solid rgba(20,38,52,1); background: rgba(20,38,52,.22); white-space:nowrap; }
    .status-pill.submitted{ background:rgba(73,167,255,.10); border-color:rgba(73,167,255,.25); color:var(--accent-blue); }
    .status-pill.under_review{ background:rgba(255,193,7,.12); border-color:rgba(255,193,7,.25); color:var(--warning); }
    .status-pill.approved{ background:rgba(61,255,122,.10); border-color:rgba(61,255,122,.25); color:var(--neon); }
    .status-pill.rejected{ background:rgba(255,107,107,.12); border-color:rgba(255,107,107,.25); color:var(--danger); }

    @media (max-width: 768px){ .table-responsive{ display:none; } }
    .users-cards{ display:none; }
    @media (max-width: 768px){ .users-cards{ display:flex; flex-direction:column; gap:12px; } .users-cards .user-card{ padding:14px; border-radius:18px; border:1px solid var(--border); background:rgba(13,24,35,.35); } }
</style>

@php
    $initials = collect(explode(' ', trim($user->name)))
        ->filter()
        ->take(2)
        ->map(fn($p)=> mb_strtoupper(mb_substr($p,0,1)))
        ->join('');

    $role = strtolower((string) $user->role);
    $roleIcon = $role === 'admin' ? '' : ($role === 'agent' ? '' : '');
    $roleClass = $role === 'admin' ? 'role-admin' : ($role === 'agent' ? 'role-agent' : 'role-client');

    $isActive = (bool) ($user->is_active ?? false);
    $statusLabel = $isActive ? 'Actif' : 'Inactif';
@endphp

<div class="premium-page">
    <div class="premium-header">
        <div>
            <div class="d-flex align-items-center gap-3">
                <div class="avatar-lg">{{ $initials }}</div>
                <div>
                    <div class="premium-title">{{ $user->name }}</div>
                    <div class="premium-sub">
                        <span><span class="muted-small">Email</span>: <b>{{ $user->email }}</b></span>
                        <span><span class="muted-small">Date d'inscription</span>: <b>{{ optional($user->created_at)->format('d/m/Y') ?? '-' }}</b></span>
                        <span><span class="muted-small">Rôle</span>: <b>{{ ucfirst($user->role) }}</b></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column align-items-end gap-2" style="min-width:260px;">
            <div class="role-badge {{ $roleClass }}">{{ $roleIcon }} {{ ucfirst($user->role) }}</div>
            <div class="badge-status {{ $isActive ? 'status-active' : 'status-inactive' }}">
                <span style="font-size:1.1rem;">{{ $isActive ? '🟢' : '🔴' }}</span>
                {{ $statusLabel }}
            </div>
        </div>
    </div>

    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-row">
                <div class="stat-ico"><i class="bi bi-person"></i></div>
                <div>
                    <p class="stat-label">Demandes de crédit</p>
                    <p class="stat-value">{{ $user->loanApplications->count() }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-row">
                <div class="stat-ico" style="background:rgba(73,167,255,.10); border-color:rgba(73,167,255,.22); color:var(--accent-blue)"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <p class="stat-label">Soumis</p>
                    <p class="stat-value">{{ $user->loanApplications->where('status','submitted')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-row">
                <div class="stat-ico" style="background:rgba(255,193,7,.10); border-color:rgba(255,193,7,.22); color:var(--warning)"><i class="bi bi-clipboard-check"></i></div>
                <div>
                    <p class="stat-label">En cours</p>
                    <p class="stat-value">{{ $user->loanApplications->where('status','under_review')->count() }}</p>
                </div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-row">
                <div class="stat-ico" style="background:rgba(61,255,122,.10); border-color:rgba(61,255,122,.22); color:var(--neon)"><i class="bi bi-check2-circle"></i></div>
                <div>
                    <p class="stat-label">Approuvés</p>
                    <p class="stat-value">{{ $user->loanApplications->whereIn('status',['approved','disbursed'])->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid-2" style="margin-top: 12px;">
        <div class="glass-card">
            <div class="card-title"><span class="dot"></span> Client</div>
            <div class="kv">
                <div class="kv-row"><div class="k">Nom</div><div class="v">{{ $user->name }}</div></div>
                <div class="kv-row"><div class="k">Email</div><div class="v">{{ $user->email }}</div></div>
                <div class="kv-row"><div class="k">Téléphone</div><div class="v">{{ $user->phone ?? '-' }}</div></div>
                <div class="kv-row"><div class="k">Adresse</div><div class="v">{{ $user->address ?? '-' }}</div></div>
                <div class="kv-row"><div class="k">Date d'inscription</div><div class="v">{{ optional($user->created_at)->format('d/m/Y') ?? '-' }}</div></div>
            </div>
        </div>

        <div class="glass-card">
            <div class="card-title"><span class="dot"></span> Résumé financier</div>
            @php
                $totalRequested = $user->loanApplications->sum(fn($l)=> (float) ($l->amount_requested ?? 0));
                $totalApproved = $user->loanApplications->sum(fn($l)=> (float) ($l->amount_approved ?? 0));
                $totalApprovedOnly = $user->loanApplications->whereIn('status',['approved','disbursed'])->count();
            @endphp
            <div class="kv">
                <div class="kv-row"><div class="k">Total demandé</div><div class="v">{{ number_format($totalRequested, 0, ',', ' ') }} CDF</div></div>
                <div class="kv-row"><div class="k">Total approuvé</div><div class="v">{{ number_format($totalApproved, 0, ',', ' ') }} CDF</div></div>
                <div class="kv-row"><div class="k">Crédits approuvés</div><div class="v">{{ $totalApprovedOnly }}</div></div>
            </div>
        </div>
    </div>

    <div class="glass-card" style="margin-top: 12px;">
        <div class="card-title"><span class="dot"></span> Demandes de crédit</div>

        <div class="table-responsive">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($user->loanApplications as $loan)
                        @php
                            $st = (string) ($loan->status ?? '');
                            $pillClass = $st === 'submitted' ? 'submitted' : ($st === 'under_review' ? 'under_review' : ($st === 'rejected' ? 'rejected' : 'approved'));
                        @endphp
                        <tr>
                            <td><a href="{{ route('admin.loans.show', $loan) }}" style="color:var(--text); font-weight:900;">{{ $loan->reference }}</a></td>
                            <td>{{ number_format((float)($loan->amount_requested ?? 0), 2) }} CDF</td>
                            <td><span class="status-pill {{ $pillClass }}">{{ ucfirst(str_replace('_',' ',$st)) }}</span></td>
                            <td>{{ optional($loan->created_at)->format('d/m/Y') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center" style="padding:22px 0; color:var(--muted);">Aucune demande.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="users-cards">
            @forelse($user->loanApplications as $loan)
                @php
                    $st = (string) ($loan->status ?? '');
                    $pillClass = $st === 'submitted' ? 'submitted' : ($st === 'under_review' ? 'under_review' : ($st === 'rejected' ? 'rejected' : 'approved'));
                    $stLabel = $st ? ucfirst(str_replace('_',' ',$st)) : '-';
                @endphp
                <div class="user-card">
                    <div class="d-flex align-items-start justify-content-between gap-2">
                        <div>
                            <div style="font-weight:1000;">{{ $loan->reference }}</div>
                            <div style="color:var(--muted); font-weight:800; font-size:.9rem; margin-top:4px;">{{ optional($loan->created_at)->format('d/m/Y') ?? '-' }}</div>
                        </div>
                        <span class="status-pill {{ $pillClass }}">{{ $stLabel }}</span>
                    </div>
                    <div style="margin-top:10px; color:var(--text); font-weight:950;">{{ number_format((float)($loan->amount_requested ?? 0), 2) }} CDF</div>
                    <div style="margin-top:10px;">
                        <a href="{{ route('admin.loans.show', $loan) }}" class="btn btn-sm btn-outline-primary">Ouvrir</a>
                    </div>
                </div>
            @empty
                <div class="user-card" style="color:var(--muted);">Aucune demande.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

