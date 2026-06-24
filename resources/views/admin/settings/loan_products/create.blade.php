@extends('layouts.dashboard')

@section('title', 'Nouveau type de crédit')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Nouveau type de crédit</h2>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.loan-products.store') }}">
            @csrf
            @include('admin.settings.loan_products._form')
            <button class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('admin.settings.loan-products.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection
