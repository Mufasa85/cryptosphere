@extends('layouts.dashboard')

@section('title', 'Gestion des crédits')

@section('dashboard-content')
    <div class="pt-3 pb-2 mb-3 border-bottom">
        <h2 style="margin:0;">Tous les crédits</h2>
    </div>

    <form method="GET" class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Référence ou client..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Tous les statuts</option>
                <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Soumis</option>
                <option value="under_review" {{ request('status') === 'under_review' ? 'selected' : '' }}>En cours</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approuvé</option>
                <option value="disbursed" {{ request('status') === 'disbursed' ? 'selected' : '' }}>Décaissé</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejeté</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Filtrer</button>
        </div>
    </form>

    <div class="loans-wrap">
        @include('admin.loans._premium_table', ['loans' => $loans])
        <div class="d-flex justify-content-end mt-3">
            {{ $loans->links() }}
        </div>
    </div>
@endsection

