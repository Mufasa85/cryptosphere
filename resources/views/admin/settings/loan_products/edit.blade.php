@extends('layouts.dashboard')

@section('title', 'Modifier le type de crédit')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Modifier le type de crédit</h2>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.loan-products.update', $loanProduct) }}">
            @csrf
            @method('PUT')
            @include('admin.settings.loan_products._form', ['product' => $loanProduct])
            <button class="btn btn-primary">Mettre à jour</button>
            <a href="{{ route('admin.settings.loan-products.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection
