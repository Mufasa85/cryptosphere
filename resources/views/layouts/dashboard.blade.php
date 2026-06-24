@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar min-vh-100">
            <div class="position-sticky pt-4">
                <div class="d-flex align-items-center gap-2 mb-4 px-3 d-none d-md-flex">
                    <img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}" style="width:28px;height:28px;object-fit:cover;object-position:center;border-radius:50%;box-shadow:0 0 12px #00C45A;">
                    <span class="fw-bold fs-5">{{ config('app.name') }}</span>
                </div>
                <ul class="nav flex-column">
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Tableau de bord</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people"></i> Utilisateurs</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.loans.*') ? 'active' : '' }}" href="{{ route('admin.loans.index') }}"><i class="bi bi-cash-stack"></i> Crédits</a></li>

                        <li class="nav-item mt-3"><span class="nav-link disabled text-muted small text-uppercase">Gestion financière</span></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.financial.*') ? 'active' : '' }}" href="{{ route('admin.financial.index') }}"><i class="bi bi-bank"></i> Vue d'ensemble</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.financial.disbursements') ? 'active' : '' }}" href="{{ route('admin.financial.disbursements') }}"><i class="bi bi-cash"></i> Décaissements</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.financial.repayments') ? 'active' : '' }}" href="{{ route('admin.financial.repayments') }}"><i class="bi bi-credit-card"></i> Remboursements</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.financial.penalties') ? 'active' : '' }}" href="{{ route('admin.financial.penalties') }}"><i class="bi bi-exclamation-circle"></i> Pénalités</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.financial.revenue') ? 'active' : '' }}" href="{{ route('admin.financial.revenue') }}"><i class="bi bi-graph-up"></i> Revenus</a></li>

                        <li class="nav-item mt-3"><span class="nav-link disabled text-muted small text-uppercase">Paramètres</span></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.settings.loan-products.*') ? 'active' : '' }}" href="{{ route('admin.settings.loan-products.index') }}"><i class="bi bi-layers"></i> Types de crédits</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.settings.index', 'admin.settings.update') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}"><i class="bi bi-gear"></i> Système</a></li>

                        <li class="nav-item mt-3"><span class="nav-link disabled text-muted small text-uppercase">Rapports</span></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}"><i class="bi bi-file-earmark-bar-graph"></i> Général</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.reports.credits') ? 'active' : '' }}" href="{{ route('admin.reports.credits') }}"><i class="bi bi-file-earmark-text"></i> Rapport des crédits</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.reports.financial') ? 'active' : '' }}" href="{{ route('admin.reports.financial') }}"><i class="bi bi-file-earmark-spreadsheet"></i> Rapport financier</a></li>

                        <li class="nav-item mt-3"><span class="nav-link disabled text-muted small text-uppercase">Sécurité</span></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.security.activity-logs') ? 'active' : '' }}" href="{{ route('admin.security.activity-logs') }}"><i class="bi bi-journal-text"></i> Journal d'activités</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.security.login-histories') ? 'active' : '' }}" href="{{ route('admin.security.login-histories') }}"><i class="bi bi-clock-history"></i> Connexions</a></li>

                        <li class="nav-item mt-3"><span class="nav-link disabled text-muted small text-uppercase">Mon compte</span></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.account.*') ? 'active' : '' }}" href="{{ route('admin.account.profile') }}"><i class="bi bi-person"></i> Profil</a></li>
                    @elseif(auth()->user()->isAgent())
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('agent.dashboard') ? 'active' : '' }}" href="{{ route('agent.dashboard') }}"><i class="bi bi-speedometer2"></i> Tableau de bord</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('agent.validations.*') ? 'active' : '' }}" href="{{ route('agent.validations.index') }}"><i class="bi bi-check2-square"></i> Validations</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('agent.clients.*') ? 'active' : '' }}" href="{{ route('agent.clients.index') }}"><i class="bi bi-people"></i> Clients</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('agent.loans.*') ? 'active' : '' }}" href="{{ route('agent.loans.index') }}"><i class="bi bi-cash-stack"></i> Crédits</a></li>

                        <li class="nav-item mt-3"><span class="nav-link disabled text-muted small text-uppercase">Remboursements</span></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('agent.repayments.create') ? 'active' : '' }}" href="{{ route('agent.repayments.create') }}"><i class="bi bi-cash-coin"></i> Encaisser remboursement</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('agent.repayments.index') ? 'active' : '' }}" href="{{ route('agent.repayments.index') }}"><i class="bi bi-clock-history"></i> Historique paiements</a></li>

                        <li class="nav-item mt-3"><span class="nav-link disabled text-muted small text-uppercase">Rapports</span></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('agent.reports.daily') ? 'active' : '' }}" href="{{ route('agent.reports.daily') }}"><i class="bi bi-calendar-day"></i> Rapport quotidien</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('agent.reports.monthly') ? 'active' : '' }}" href="{{ route('agent.reports.monthly') }}"><i class="bi bi-calendar-month"></i> Rapport mensuel</a></li>

                        <li class="nav-item mt-3"><span class="nav-link disabled text-muted small text-uppercase">Mon compte</span></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('agent.profile.*') ? 'active' : '' }}" href="{{ route('agent.profile.edit') }}"><i class="bi bi-person"></i> Profil</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}" href="{{ route('client.dashboard') }}"><i class="bi bi-speedometer2"></i> Tableau de bord</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('client.loans.*') ? 'active' : '' }}" href="{{ route('client.loans.index') }}"><i class="bi bi-cash-stack"></i> Mes crédits</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('client.repayments.*') ? 'active' : '' }}" href="{{ route('client.repayments.index') }}"><i class="bi bi-credit-card"></i> Remboursements</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('client.profile.*') ? 'active' : '' }}" href="{{ route('client.profile.edit') }}"><i class="bi bi-person"></i> Profil</a></li>
                    @endif
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 dashboard-content">
            @include('layouts.partials.alerts')
            @yield('dashboard-content')
        </main>
    </div>
</div>
@endsection
