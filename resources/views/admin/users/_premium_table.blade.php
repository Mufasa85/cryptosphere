{{--
  Component: Premium Users Table (Desktop) + Cards (Mobile)
  Expected variables:
  - $users : paginator/collection of User model
  - route helpers: admin.users.show, admin.users.toggle-active, admin.users.destroy
--}}

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
    }

    .users-wrap{ background: rgba(13,24,35,.35); border:1px solid var(--border); border-radius:22px; padding:18px; }

    .stat-grid{ display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:12px; margin:14px 0 16px; }
    @media (max-width: 992px){ .stat-grid{ grid-template-columns:repeat(2,minmax(0,1fr)); } }
    @media (max-width: 576px){ .stat-grid{ grid-template-columns:1fr; } }

    .stat-item{ padding:14px; border-radius:18px; border:1px solid rgba(20,38,52,1); background:rgba(13,24,35,.35); transition:transform .25s, box-shadow .25s, border-color .25s; }
    .stat-item:hover{ transform:translateY(-3px); border-color:rgba(61,255,122,.35); box-shadow:0 0 22px rgba(0,196,90,.12); }
    .stat-label{ color:var(--muted); font-size:.82rem; margin:0 0 8px; font-weight:700; text-transform:uppercase; letter-spacing:.06em; display:flex; align-items:center; gap:10px; }
    .stat-value{ margin:0; font-size:1.45rem; font-weight:900; color:var(--text); }
    .stat-icon{ width:34px; height:34px; border-radius:12px; display:grid; place-items:center; border:1px solid rgba(61,255,122,.22); background:rgba(61,255,122,.10); color:var(--neon); box-shadow:0 0 18px rgba(0,196,90,.10); }

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
    .badge-admin{ background:rgba(61,255,122,.10); border-color:rgba(61,255,122,.25); color:var(--neon); box-shadow:0 0 18px rgba(0,196,90,.12); }
    .badge-agent{ background:rgba(73,167,255,.10); border-color:rgba(73,167,255,.25); color:var(--accent-blue); }
    .badge-client{ background:rgba(61,255,122,.07); border-color:rgba(61,255,122,.18); color:var(--text); }

    .status-pill{ display:inline-flex; align-items:center; gap:8px; padding:7px 11px; border-radius:999px; font-weight:950; font-size:.82rem; border:1px solid rgba(20,38,52,1); background:rgba(20,38,52,.22); white-space:nowrap; }
    .status-active{ background:rgba(61,255,122,.10); border-color:rgba(61,255,122,.25); color:var(--neon); }
    .status-suspended{ background:rgba(255,138,61,.12); border-color:rgba(255,138,61,.25); color:#FF8A3D; }
    .status-blocked{ background:rgba(255,107,107,.12); border-color:rgba(255,107,107,.25); color:var(--danger); }

    .icon-btn{ width:38px; height:38px; border-radius:12px; display:inline-grid; place-items:center; border:1px solid var(--border); background:rgba(7,19,27,.25); color:var(--muted); transition:transform .2s ease, box-shadow .2s ease, border-color .2s ease, color .2s ease, background .2s ease; text-decoration:none; }
    .icon-btn:hover{ transform:translateY(-3px); color:var(--neon); border-color:rgba(61,255,122,.35); box-shadow:0 0 18px rgba(0,196,90,.14); background:rgba(61,255,122,.06); }
    .icon-btn-danger:hover{ color:var(--danger); border-color:rgba(255,107,107,.35); box-shadow:0 0 18px rgba(255,107,107,.14); }
    .icon-btn-warning:hover{ color:var(--warning); border-color:rgba(255,193,7,.35); box-shadow:0 0 18px rgba(255,193,7,.14); }

    .users-cards{ display:none; gap:12px; flex-direction:column; margin-top:12px; }
    @media (max-width: 768px){ .table-responsive{ display:none; } .users-cards{ display:flex; } }

    .user-card{ padding:14px; border-radius:18px; border:1px solid var(--border); background:rgba(13,24,35,.35); }
    .user-card-top{ display:flex; align-items:flex-start; justify-content:space-between; gap:10px; }
    .user-card-actions{ display:flex; gap:10px; flex-wrap:wrap; margin-top:12px; }

    /* Pagination modern (works with Bootstrap paginate links) */
    .pagination{ margin-top:14px; }
    .pagination .page-link{ background:transparent; border-color:rgba(20,38,52,1); color:var(--muted); }
    .pagination .page-link:hover{ background:rgba(61,255,122,.08); color:var(--neon); border-color:rgba(20,38,52,1); }
    .pagination .page-item.active .page-link{ background:var(--neon); border-color:var(--neon); color:var(--bg-primary); }

    [data-bs-toggle="tooltip"]{ cursor:pointer; }
</style>

{{-- Counters --}}
@php
    $totalUsers = $users->total();
    $totalClients = $users->where('role','client')->count();
    $totalAgents  = $users->where('role','agent')->count();
    $totalCredits = $users->sum('loan_applications_count');
@endphp

<div class="stat-grid">
    <div class="stat-item">
        <div class="stat-label"><span class="stat-icon"><i class="bi bi-people"></i></span> Total utilisateurs</div>
        <p class="stat-value">{{ $totalUsers }}</p>
    </div>
    <div class="stat-item">
        <div class="stat-label"><span class="stat-icon" style="background:rgba(73,167,255,.10);border-color:rgba(73,167,255,.25);color:var(--accent-blue)"><i class="bi bi-person-badge"></i></span> Total clients</div>
        <p class="stat-value">{{ $totalClients }}</p>
    </div>
    <div class="stat-item">
        <div class="stat-label"><span class="stat-icon" style="background:rgba(61,255,122,.08);border-color:rgba(61,255,122,.20);color:var(--neon)"><i class="bi bi-briefcase"></i></span> Total agents</div>
        <p class="stat-value">{{ $totalAgents }}</p>
    </div>
    <div class="stat-item">
        <div class="stat-label"><span class="stat-icon" style="background:rgba(255,193,7,.08);border-color:rgba(255,193,7,.20);color:var(--warning)"><i class="bi bi-cash-coin"></i></span> Total crédits</div>
        <p class="stat-value">{{ $totalCredits }}</p>
    </div>
</div>

{{-- Desktop table --}}
<div class="table-responsive">
    <table class="table-premium">
        <thead>
            <tr>
                <th>Client</th>
                <th>Rôle</th>
                <th>Demandes</th>
                <th>Statut</th>
                <th>Date d'inscription</th>
                <th>Montant total emprunté</th>
                <th>Crédit restant</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $user)
            @php
                $initials = collect(explode(' ', trim($user->name)))
                    ->filter()
                    ->take(2)
                    ->map(fn($p)=> mb_strtoupper(mb_substr($p,0,1)))
                    ->join('');

                $role = strtolower((string) $user->role);
                $roleLabel = ucfirst($user->role);

                $roleBadgeClass = match($role){
                    'admin' => 'badge-admin',
                    'agent' => 'badge-agent',
                    'client' => 'badge-client',
                    default => '',
                };

                // Status mapping requested: Actif=Vert, Suspendu=Orange, Bloqué=Rouge.
                // Best-effort mapping based on existing boolean is_active.
                $statusLabel = $user->is_active ? 'Actif' : 'Bloqué';
                $statusClass = $user->is_active ? 'status-active' : 'status-blocked';

                $createdAt = optional($user->created_at)->format('d/m/Y');

                // If your User model has these attributes via relations/scopes, use them.
                $totalBorrowed = data_get($user, 'total_borrowed', null);
                $remainingCredit = data_get($user, 'remaining_credit', null);
            @endphp

            <tr>
                <td>
                    <div class="user-cell">
                        <div class="avatar">{{ $initials }}</div>
                        <div class="user-meta">
                            <div class="user-name">{{ $user->name }}</div>
                            <div class="user-email">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge-premium {{ $roleBadgeClass }}">
                        @if($role === 'admin') @elseif($role === 'agent') @else @endif
                        {{ $roleLabel }}
                    </span>
                </td>
                <td>{{ $user->loan_applications_count }}</td>
                <td>
                    <span class="status-pill {{ $statusClass }}">{{ $statusLabel }}</span>
                </td>
                <td>{{ $createdAt ?? '-' }}</td>
                <td>{{ $totalBorrowed !== null ? number_format((float)$totalBorrowed, 2) . ' CDF' : '-' }}</td>
                <td>{{ $remainingCredit !== null ? number_format((float)$remainingCredit, 2) . ' CDF' : '-' }}</td>

                <td>
                    <div class="d-flex gap-2 align-items-center">
                        <a href="{{ route('admin.users.show', $user) }}"
                           class="icon-btn"
                           data-bs-toggle="tooltip"
                           data-bs-placement="top"
                           title="Voir">
                            <i class="bi bi-eye"></i>
                        </a>

                        <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}" onsubmit="return confirm('Êtes-vous sûr ?')">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="icon-btn {{ $user->is_active ? 'icon-btn-warning' : '' }}"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="{{ $user->is_active ? 'Désactiver' : 'Activer' }}"
                                    style="background:rgba(7,19,27,.25); border:1px solid var(--border);">
                                <i class="bi bi-pause"></i>
                            </button>
                        </form>

                        @if(! $user->isAdmin())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Supprimer ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="icon-btn icon-btn-danger"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="Supprimer"
                                        style="background:rgba(7,19,27,.25);">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endif

                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center" style="padding:22px 0;color:var(--muted);">Aucun utilisateur.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- Mobile cards --}}
<div class="users-cards">
    @forelse($users as $user)
        @php
            $initials = collect(explode(' ', trim($user->name)))
                ->filter()
                ->take(2)
                ->map(fn($p)=> mb_strtoupper(mb_substr($p,0,1)))
                ->join('');

            $role = strtolower((string) $user->role);
            $roleLabel = ucfirst($user->role);

            $roleBadgeClass = match($role){
                'admin' => 'badge-admin',
                'agent' => 'badge-agent',
                'client' => 'badge-client',
                default => '',
            };

            $statusLabel = $user->is_active ? 'Actif' : 'Bloqué';
            $statusClass = $user->is_active ? 'status-active' : 'status-blocked';

            $createdAt = optional($user->created_at)->format('d/m/Y');
        @endphp

        <div class="user-card">
            <div class="user-card-top">
                <div class="user-cell" style="min-width:0;">
                    <div class="avatar">{{ $initials }}</div>
                    <div class="user-meta">
                        <div class="user-name">{{ $user->name }}</div>
                        <div class="user-email">{{ $user->email }}</div>
                    </div>
                </div>
                <span class="badge-premium {{ $roleBadgeClass }}">
                    @if($role === 'admin') 👑 @elseif($role === 'agent') 💼 @else 👤 @endif
                    {{ $roleLabel }}
                </span>
            </div>

            <div class="d-flex gap-2 flex-wrap mt-3 align-items-center">
                <span class="status-pill {{ $statusClass }}">{{ $statusLabel }}</span>
                <span class="badge-premium" style="background:rgba(20,38,52,.18);">
                    <i class="bi bi-calendar3 me-1"></i> {{ $createdAt ?? '-' }}
                </span>
            </div>

            <div class="user-card-actions">
                <a href="{{ route('admin.users.show', $user) }}"
                   class="icon-btn"
                   data-bs-toggle="tooltip"
                   data-bs-placement="top"
                   title="Voir">
                    <i class="bi bi-eye"></i>
                </a>

                <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}" onsubmit="return confirm('Êtes-vous sûr ?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="icon-btn {{ $user->is_active ? 'icon-btn-warning' : '' }}"
                            data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="{{ $user->is_active ? 'Désactiver' : 'Activer' }}">
                        <i class="bi bi-pause"></i>
                    </button>
                </form>

                @if(! $user->isAdmin())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Supprimer ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="icon-btn icon-btn-danger"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Supprimer">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="user-card">Aucun utilisateur.</div>
    @endforelse
</div>

<script>
    // Bootstrap tooltips init
    (function(){
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    })();
</script>

