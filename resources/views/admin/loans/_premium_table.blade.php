{{--
  Component: Premium Loans Table (Desktop) + Cards (Mobile)
  Expected variables:
  - $loans : paginator/collection of LoanApplication (admin context)
  - routes:
    - admin.loans.show
--}}

<style>
    /* Use same fintech palette as users premium */
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

    .loans-wrap{ background: rgba(13,24,35,.35); border:1px solid var(--border); border-radius:22px; padding:18px; }

    .stat-grid{ display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:12px; margin:14px 0 16px; }
    @media (max-width: 992px){ .stat-grid{ grid-template-columns:repeat(2,minmax(0,1fr)); } }
    @media (max-width: 576px){ .stat-grid{ grid-template-columns:1fr; } }

    .stat-item{ padding:14px; border-radius:18px; border:1px solid rgba(20,38,52,1); background:rgba(13,24,35,.35); transition:transform .25s, box-shadow .25s, border-color .25s; }
    .stat-item:hover{ transform:translateY(-3px); border-color:rgba(61,255,122,.35); box-shadow:0 0 22px rgba(0,196,90,.12); }
    .stat-label{ color:var(--muted); font-size:.82rem; margin:0 0 8px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; display:flex; align-items:center; gap:10px; }
    .stat-value{ margin:0; font-size:1.45rem; font-weight:900; color:var(--text); }
    .stat-icon{ width:34px; height:34px; border-radius:12px; display:grid; place-items:center; border:1px solid rgba(61,255,122,.22); background:rgba(61,255,122,.10); color:var(--neon); box-shadow:0 0 18px rgba(0,196,90,.10); }

    /* Desktop table */
    .table-premium{ width:100%; border-collapse:separate; border-spacing:0; border-radius:18px; border:1px solid var(--border); background:rgba(13,24,35,.35); overflow:hidden; }
    .table-premium thead th{ background:rgba(7,19,27,.45); border-bottom:1px solid rgba(20,38,52,1); color:var(--muted); font-size:.78rem; font-weight:900; letter-spacing:.06em; text-transform:uppercase; padding:14px 14px; white-space:nowrap; }
    .table-premium tbody td{ padding:12px 14px; border-top:1px solid rgba(20,38,52,.7); vertical-align:middle; color:var(--text); }
    .table-premium tbody tr{ transition:transform .25s ease; }
    .table-premium tbody tr:hover td{ background:rgba(61,255,122,.05); }
    .table-premium tbody tr:hover{ transform:translateY(-2px); }

    .user-cell{ display:flex; align-items:center; gap:12px; min-width:240px; }
    .avatar{ width:40px; height:40px; border-radius:999px; background:linear-gradient(135deg, rgba(61,255,122,.18), rgba(0,196,90,.10)); border:1px solid rgba(61,255,122,.22); color:var(--neon); display:flex; align-items:center; justify-content:center; font-weight:950; box-shadow:0 0 18px rgba(0,196,90,.12); flex:0 0 auto; }
    .user-meta{ display:flex; flex-direction:column; line-height:1.15; gap:4px; min-width:0; }
    .user-name{ font-weight:900; color:var(--text); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    .user-email{ color:var(--muted); font-size:.86rem; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:280px; }

    .badge-premium{ display:inline-flex; align-items:center; gap:8px; padding:7px 11px; border-radius:999px; font-weight:950; font-size:.82rem; border:1px solid rgba(20,38,52,1); background:rgba(20,38,52,.22); color:var(--text); white-space:nowrap; }

    /* Status mapping (pending/under_review/approved/disbursed/rejected) */
    .status-pill{ display:inline-flex; align-items:center; gap:8px; padding:7px 11px; border-radius:999px; font-weight:950; font-size:.82rem; border:1px solid rgba(20,38,52,1); background:rgba(20,38,52,.22); white-space:nowrap; }
    .status-submitted{ background:rgba(73,167,255,.10); border-color:rgba(73,167,255,.25); color:var(--accent-blue); }
    .status-under_review{ background:rgba(255,193,7,.12); border-color:rgba(255,193,7,.25); color:var(--warning); }
    .status-approved{ background:rgba(61,255,122,.10); border-color:rgba(61,255,122,.25); color:var(--neon); }
    .status-disbursed{ background:rgba(61,255,122,.10); border-color:rgba(0,196,90,.35); color:var(--neon); box-shadow:0 0 22px rgba(0,196,90,.12); }
    .status-rejected{ background:rgba(255,107,107,.12); border-color:rgba(255,107,107,.25); color:var(--danger); }

    .icon-btn{ width:38px; height:38px; border-radius:12px; display:inline-grid; place-items:center; border:1px solid var(--border); background:rgba(7,19,27,.25); color:var(--muted); transition:transform .2s ease, box-shadow .2s ease, border-color .2s ease, color .2s ease, background .2s ease; text-decoration:none; }
    .icon-btn:hover{ transform:translateY(-3px); color:var(--neon); border-color:rgba(61,255,122,.35); box-shadow:0 0 18px rgba(0,196,90,.14); background:rgba(61,255,122,.06); }
    .icon-btn i{ font-size:1.05rem; }

    .users-cards{ display:none; gap:12px; flex-direction:column; margin-top:12px; }
    @media (max-width: 768px){ .table-responsive{ display:none; } .users-cards{ display:flex; } }

    .user-card{ padding:14px; border-radius:18px; border:1px solid var(--border); background:rgba(13,24,35,.35); }
    .user-card-top{ display:flex; align-items:flex-start; justify-content:space-between; gap:10px; }
    .user-card-actions{ display:flex; gap:10px; flex-wrap:wrap; margin-top:12px; }

    .pagination{ margin-top:14px; }
</style>

@php
    $totalLoans = $loans->total();
@endphp

<div class="stat-grid">
    <div class="stat-item">
        <div class="stat-label"><span class="stat-icon"><i class="bi bi-cash-stack"></i></span> Total crédits</div>
        <p class="stat-value">{{ $totalLoans }}</p>
    </div>
    <div class="stat-item">
        <div class="stat-label"><span class="stat-icon" style="background:rgba(73,167,255,.10);border-color:rgba(73,167,255,.20);color:var(--accent-blue)"><i class="bi bi-hourglass-split"></i></span> Soumis</div>
        <p class="stat-value">{{ $loans->where('status','submitted')->count() }}</p>
    </div>
    <div class="stat-item">
        <div class="stat-label"><span class="stat-icon" style="background:rgba(255,193,7,.10);border-color:rgba(255,193,7,.20);color:var(--warning)"><i class="bi bi-clipboard-check"></i></span> En cours</div>
        <p class="stat-value">{{ $loans->where('status','under_review')->count() }}</p>
    </div>
    <div class="stat-item">
        <div class="stat-label"><span class="stat-icon" style="background:rgba(61,255,122,.08);border-color:rgba(61,255,122,.20);color:var(--neon)"><i class="bi bi-bank2"></i></span> Décaissés</div>
        <p class="stat-value">{{ $loans->where('status','disbursed')->count() }}</p>
    </div>
</div>

{{-- Desktop table --}}
<div class="table-responsive">
    <table class="table-premium">
        <thead>
        <tr>
            <th>Référence</th>
            <th>Client</th>
            <th>Montant</th>
            <th>Statut</th>
            <th>Agent</th>
            <th>Date</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($loans as $loan)
            @php
                $created = optional($loan->created_at)->format('d/m/Y');
                $status = (string) $loan->status;
                $statusClass = match($status){
                    'submitted' => 'status-submitted',
                    'under_review' => 'status-under_review',
                    'approved' => 'status-approved',
                    'disbursed' => 'status-disbursed',
                    'rejected' => 'status-rejected',
                    default => 'status-submitted',
                };

                $clientInitials = collect(explode(' ', trim($loan->user->name ?? '')))
                    ->filter()
                    ->take(2)
                    ->map(fn($p)=> mb_strtoupper(mb_substr($p,0,1)))
                    ->join('');
            @endphp
            <tr>
                <td><a href="{{ route('admin.loans.show', $loan) }}" style="color:var(--text); font-weight:900;">{{ $loan->reference }}</a></td>

                <td>
                    <div class="user-cell">
                        <div class="avatar">{{ $clientInitials }}</div>
                        <div class="user-meta">
                            <div class="user-name">{{ $loan->user->name ?? '-' }}</div>
                        </div>
                    </div>
                </td>

                <td>{{ number_format((float) ($loan->amount_requested ?? 0), 2) }} CDF</td>

                <td>
                    <span class="status-pill {{ $statusClass }}">
                        {{ ucfirst(str_replace('_',' ', $status)) }}
                    </span>
                </td>

                <td>{{ $loan->agent?->name ?? '-' }}</td>
                <td>{{ $created ?? '-' }}</td>

                <td>
                    <a href="{{ route('admin.loans.show', $loan) }}" class="icon-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Voir">
                        <i class="bi bi-eye"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center" style="padding:22px 0;color:var(--muted);">Aucun crédit.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- Mobile cards --}}
<div class="users-cards">
    @forelse($loans as $loan)
        @php
            $status = (string) $loan->status;
            $statusClass = match($status){
                'submitted' => 'status-submitted',
                'under_review' => 'status-under_review',
                'approved' => 'status-approved',
                'disbursed' => 'status-disbursed',
                'rejected' => 'status-rejected',
                default => 'status-submitted',
            };
            $clientInitials = collect(explode(' ', trim($loan->user->name ?? '')))
                ->filter()
                ->take(2)
                ->map(fn($p)=> mb_strtoupper(mb_substr($p,0,1)))
                ->join('');
        @endphp
        <div class="user-card">
            <div class="user-card-top">
                <div class="user-cell" style="min-width:0;">
                    <div class="avatar">{{ $clientInitials }}</div>
                    <div class="user-meta">
                        <div class="user-name">{{ $loan->user->name ?? '-' }}</div>
                        <div class="user-email">Ref: {{ $loan->reference }}</div>
                    </div>
                </div>

                <span class="status-pill {{ $statusClass }}">
                    {{ ucfirst(str_replace('_',' ', $status)) }}
                </span>
            </div>

            <div class="mt-3" style="color:var(--muted); font-weight:700;">
                {{ number_format((float) ($loan->amount_requested ?? 0), 2) }} CDF
            </div>
            <div style="color:var(--muted); font-size:.9rem; margin-top:6px;">
                Agent: {{ $loan->agent?->name ?? '-' }} • Date: {{ optional($loan->created_at)->format('d/m/Y') ?? '-' }}
            </div>

            <div class="user-card-actions">
                <a href="{{ route('admin.loans.show', $loan) }}" class="icon-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Voir">
                    <i class="bi bi-eye"></i>
                </a>
            </div>
        </div>
    @empty
        <div class="user-card" style="color:var(--muted);">Aucun crédit.</div>
    @endforelse
</div>

<script>
    (function(){
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    })();
</script>

