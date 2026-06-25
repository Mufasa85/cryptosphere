@extends('layouts.dashboard')

@section('title', 'Gestion des utilisateurs')

@section('dashboard-content')
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <h2 style="margin:0;">Utilisateurs</h2>
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
            <button type="submit" class="btn btn-primary">Filtrer</button>
        </div>
    </form>

    <div class="users-wrap">
        @include('admin.users._premium_table', ['users' => $users])
        <div class="d-flex justify-content-end mt-3">
            {{ $users->links() }}
        </div>
    </div>
@endsection


