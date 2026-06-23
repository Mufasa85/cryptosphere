<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --bg-primary: #050B12;
            --bg-secondary: #07131B;
            --bg-tertiary: #0B1E2B;
            --bg-card: #0D1823;
            --border: #142634;
            --neon: #3DFF7A;
            --glow: #00C45A;
            --text: #E9F2F7;
            --muted: #AEBBC6;
            --accent-blue: #49A7FF;
            --danger: #FF6B6B;
            --warning: #FFC107;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background: var(--bg-primary);
            color: var(--text);
            min-height: 100vh;
        }

        a { color: var(--neon); text-decoration: none; }
        a:hover { color: var(--glow); }

        h1, h2, h3, h4, h5, h6 { font-weight: 700; }

        .navbar {
            background: rgba(7, 19, 27, 0.88);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
            padding: 14px 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-brand img {
            width: 36px;
            height: 36px;
            object-fit: cover;
            object-position: center;
            border-radius: 50%;
            box-shadow: 0 0 12px var(--glow);
        }

        .navbar .nav-link {
            color: var(--muted);
            font-weight: 500;
            padding: 8px 14px;
            border-radius: 8px;
            transition: all 0.25s;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            color: var(--neon);
            background: rgba(61, 255, 122, 0.08);
        }

        .navbar-toggler { border-color: var(--border); }
        .navbar-toggler-icon { filter: invert(1); }

        .dropdown-menu {
            background: var(--bg-card);
            border: 1px solid var(--border);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        }

        .dropdown-item { color: var(--text); transition: all 0.2s; }
        .dropdown-item:hover { background: rgba(61, 255, 122, 0.1); color: var(--neon); }
        .dropdown-divider { border-color: var(--border); }

        main { background: var(--bg-primary); min-height: calc(100vh - 70px); }

        .auth-page {
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at top right, rgba(0, 196, 90, 0.12), transparent 45%),
                radial-gradient(circle at bottom left, rgba(73, 167, 255, 0.08), transparent 45%);
            padding: 40px 0;
        }

        .auth-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 24px;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .auth-logo-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, #3DFF7A, #00C45A);
            box-shadow: 0 0 15px #00C45A;
        }

        .dashboard-content {
            background:
                radial-gradient(circle at top right, rgba(0, 196, 90, 0.06), transparent 40%),
                radial-gradient(circle at bottom left, rgba(73, 167, 255, 0.04), transparent 40%);
            min-height: calc(100vh - 70px);
        }

        .sidebar {
            background: var(--bg-secondary) !important;
            border-right: 1px solid var(--border) !important;
        }

        .sidebar .nav-link {
            color: var(--muted);
            border-radius: 10px;
            margin: 6px 12px;
            padding: 10px 16px;
            font-weight: 500;
            transition: all 0.25s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: var(--neon);
            background: rgba(61, 255, 122, 0.08);
        }

        .sidebar .nav-link i { margin-right: 10px; }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            color: var(--text);
            box-shadow: none;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.35);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            color: var(--text);
            font-weight: 600;
            padding: 20px 24px;
        }

        .card-body { padding: 24px; }

        .table {
            color: var(--text);
            border-color: var(--border);
        }

        .table thead th {
            color: var(--muted);
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 14px 16px;
        }

        .table tbody td { padding: 14px 16px; border-color: var(--border); vertical-align: middle; }

        .table-striped > tbody > tr:nth-child(odd) > td,
        .table-striped > tbody > tr:nth-child(odd) > th {
            background: rgba(20, 38, 52, 0.35);
        }

        .table-hover > tbody > tr:hover > td,
        .table-hover > tbody > tr:hover > th {
            background: rgba(61, 255, 122, 0.05);
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 10px 22px;
            transition: all 0.25s;
            border: none;
        }

        .btn-primary {
            background: var(--neon);
            color: var(--bg-primary);
            box-shadow: 0 0 20px rgba(0, 196, 90, 0.35);
        }

        .btn-primary:hover {
            background: var(--neon-soft, #A6FF5B);
            box-shadow: 0 0 30px rgba(0, 196, 90, 0.55);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text);
        }

        .btn-secondary:hover {
            border-color: var(--neon);
            color: var(--neon);
            background: rgba(61, 255, 122, 0.08);
        }

        .btn-outline-primary {
            background: transparent;
            border: 1px solid var(--neon);
            color: var(--neon);
        }

        .btn-outline-primary:hover {
            background: var(--neon);
            color: var(--bg-primary);
        }

        .btn-success {
            background: var(--neon);
            color: var(--bg-primary);
        }

        .btn-danger {
            background: rgba(255, 107, 107, 0.12);
            color: var(--danger);
            border: 1px solid rgba(255, 107, 107, 0.3);
        }

        .btn-danger:hover {
            background: rgba(255, 107, 107, 0.22);
            color: var(--danger);
        }

        .btn-warning {
            background: rgba(255, 193, 7, 0.12);
            color: var(--warning);
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .btn-warning:hover { background: rgba(255, 193, 7, 0.22); color: var(--warning); }

        .btn-info {
            background: rgba(73, 167, 255, 0.12);
            color: var(--accent-blue);
            border: 1px solid rgba(73, 167, 255, 0.3);
        }

        .btn-info:hover { background: rgba(73, 167, 255, 0.22); color: var(--accent-blue); }

        .btn-outline-secondary { background: transparent; border: 1px solid var(--border); color: var(--muted); }
        .btn-outline-secondary:hover { border-color: var(--neon); color: var(--neon); background: rgba(61, 255, 122, 0.08); }

        .btn-outline-warning { background: transparent; border: 1px solid var(--warning); color: var(--warning); }
        .btn-outline-warning:hover { background: var(--warning); color: var(--bg-primary); }

        .btn-outline-danger { background: transparent; border: 1px solid var(--danger); color: var(--danger); }
        .btn-outline-danger:hover { background: var(--danger); color: var(--bg-primary); }

        .btn-outline-success { background: transparent; border: 1px solid var(--neon); color: var(--neon); }
        .btn-outline-success:hover { background: var(--neon); color: var(--bg-primary); }

        .btn-outline-info { background: transparent; border: 1px solid var(--accent-blue); color: var(--accent-blue); }
        .btn-outline-info:hover { background: var(--accent-blue); color: var(--bg-primary); }

        .btn-sm { padding: 8px 16px; font-size: 0.85rem; }

        .form-control, .form-select {
            background: var(--bg-tertiary);
            border: 1px solid var(--border);
            color: var(--text);
            border-radius: 12px;
            padding: 12px 16px;
            font-family: inherit;
        }

        .form-control:focus, .form-select:focus {
            background: var(--bg-tertiary);
            border-color: var(--neon);
            color: var(--text);
            box-shadow: 0 0 0 0.2rem rgba(61, 255, 122, 0.15);
        }

        .form-control::placeholder { color: var(--muted); }
        .form-label { color: var(--muted); font-size: 0.9rem; margin-bottom: 6px; }
        .input-group-text { background: var(--bg-card); border-color: var(--border); color: var(--muted); }

        .form-check-input {
            background: var(--bg-tertiary);
            border-color: var(--border);
        }

        .form-check-input:checked {
            background-color: var(--neon);
            border-color: var(--neon);
        }

        .form-check-label { color: var(--muted); }

        .invalid-feedback { color: var(--danger); font-size: 0.85rem; }
        .is-invalid { border-color: var(--danger) !important; }
        .is-invalid:focus { box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.15); }

        .badge { font-weight: 600; padding: 6px 10px; border-radius: 8px; }
        .badge.bg-primary { background: rgba(61, 255, 122, 0.12) !important; color: var(--neon); border: 1px solid rgba(61, 255, 122, 0.25); }
        .badge.bg-secondary { background: rgba(174, 187, 198, 0.12) !important; color: var(--muted); border: 1px solid rgba(174, 187, 198, 0.25); }
        .badge.bg-success { background: rgba(61, 255, 122, 0.12) !important; color: var(--neon); border: 1px solid rgba(61, 255, 122, 0.25); }
        .badge.bg-danger { background: rgba(255, 107, 107, 0.12) !important; color: var(--danger); border: 1px solid rgba(255, 107, 107, 0.25); }
        .badge.bg-warning { background: rgba(255, 193, 7, 0.12) !important; color: var(--warning); border: 1px solid rgba(255, 193, 7, 0.25); }
        .badge.bg-info { background: rgba(73, 167, 255, 0.12) !important; color: var(--accent-blue); border: 1px solid rgba(73, 167, 255, 0.25); }

        .alert { border-radius: 14px; border-width: 1px; }
        .alert-success { background: rgba(61, 255, 122, 0.1); border-color: rgba(61, 255, 122, 0.2); color: var(--neon); }
        .alert-danger { background: rgba(255, 107, 107, 0.1); border-color: rgba(255, 107, 107, 0.2); color: var(--danger); }
        .alert-warning { background: rgba(255, 193, 7, 0.1); border-color: rgba(255, 193, 7, 0.2); color: var(--warning); }
        .alert-info { background: rgba(73, 167, 255, 0.1); border-color: rgba(73, 167, 255, 0.2); color: var(--accent-blue); }

        .btn-close { filter: invert(1); opacity: 0.7; }
        .btn-close:hover { opacity: 1; }

        .pagination .page-link {
            background: var(--bg-card);
            border-color: var(--border);
            color: var(--text);
        }

        .pagination .page-link:hover {
            background: var(--bg-tertiary);
            color: var(--neon);
            border-color: var(--border);
        }

        .pagination .page-item.active .page-link {
            background: var(--neon);
            border-color: var(--neon);
            color: var(--bg-primary);
        }

        .border-bottom { border-color: var(--border) !important; }
        .border { border-color: var(--border) !important; }
        .text-muted { color: var(--muted) !important; }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 24px;
            transition: transform 0.3s;
        }

        .stat-card:hover { transform: translateY(-6px); border-color: rgba(61, 255, 122, 0.4); }
        .stat-card .stat-label { color: var(--muted); font-size: 0.85rem; margin-bottom: 6px; }
        .stat-card .stat-value { font-size: 1.8rem; font-weight: 700; color: var(--text); }

        .glass-card {
            background: rgba(13, 24, 35, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
            border-radius: 20px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}">
                {{ config('app.name') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Connexion</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Inscription</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(auth()->user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin</a></li>
                                @elseif(auth()->user()->isAgent())
                                    <li><a class="dropdown-item" href="{{ route('agent.dashboard') }}">Agent</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('client.dashboard') }}">Espace client</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Déconnexion</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
