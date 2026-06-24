@extends('layouts.dashboard')

@section('title', 'Mon compte')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Mon compte</h2>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Informations personnelles</h5>
                <form method="POST" action="{{ route('admin.account.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nouveau mot de passe</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirmation</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                    <button class="btn btn-primary">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Double authentification</h5>
                <p>
                    Statut :
                    <span class="badge bg-{{ auth()->user()->two_factor_enabled ? 'success' : 'secondary' }}">
                        {{ auth()->user()->two_factor_enabled ? 'Activé' : 'Désactivé' }}
                    </span>
                </p>
                <form method="POST" action="{{ route('admin.account.two-factor') }}">
                    @csrf
                    @method('PATCH')
                    <button class="btn btn-{{ auth()->user()->two_factor_enabled ? 'danger' : 'success' }}">
                        {{ auth()->user()->two_factor_enabled ? 'Désactiver' : 'Activer' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
