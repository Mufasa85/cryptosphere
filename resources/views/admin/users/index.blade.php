@extends('layouts.dashboard')

@section('title', 'Gestion des utilisateurs')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Utilisateurs</h2>
</div>

<form method="GET" class="row g-3 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ request('search') }}">
    </div>
    <div class="col-md-3">
        <select name="role" class="form-select">
            <option value="">Tous les rôles</option>
            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="agent" {{ request('role') === 'agent' ? 'selected' : '' }}>Agent</option>
            <option value="client" {{ request('role') === 'client' ? 'selected' : '' }}>Client</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-outline-primary">Filtrer</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Demandes</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge bg-secondary">{{ $user->role }}</span></td>
                    <td>{{ $user->loan_applications_count }}</td>
                    <td>
                        <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                            {{ $user->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </td>
                    <td class="d-flex gap-2">
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                        <form method="POST" action="{{ route('admin.users.toggle-active', $user) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-outline-warning">
                                {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                            </button>
                        </form>
                        @if(! $user->isAdmin())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Supprimer ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Aucun utilisateur.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $users->links() }}
@endsection
