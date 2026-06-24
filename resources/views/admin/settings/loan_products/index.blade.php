@extends('layouts.dashboard')

@section('title', 'Types de crédits')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom d-flex justify-content-between align-items-center">
    <h2>Types de crédits</h2>
    <a href="{{ route('admin.settings.loan-products.create') }}" class="btn btn-primary">Ajouter</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Montant</th>
                        <th>Taux</th>
                        <th>Durée</th>
                        <th>Actif</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($product->min_amount, 2) }} - {{ number_format($product->max_amount, 2) }} CDF</td>
                            <td>{{ $product->interest_rate }}%</td>
                            <td>{{ $product->duration_months }} mois</td>
                            <td>
                                <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                                    {{ $product->is_active ? 'Oui' : 'Non' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.settings.loan-products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                                <form action="{{ route('admin.settings.loan-products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">Aucun type de crédit.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $products->links() }}
    </div>
</div>
@endsection
