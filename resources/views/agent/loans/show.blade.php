@extends('layouts.dashboard')

@section('title', 'Détail crédit')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>{{ $loan->reference }}</h2>
</div>

<div class="card">
    <div class="card-body">
        <p><strong>Client :</strong> {{ $loan->user->name }}</p>
        <p><strong>Montant demandé :</strong> {{ number_format($loan->amount_requested, 2) }} CDF</p>
        <p><strong>Montant approuvé :</strong> {{ number_format($loan->amount_approved ?? 0, 2) }} CDF</p>
        <p><strong>Durée :</strong> {{ $loan->duration_months }} mois</p>
        <p><strong>Taux :</strong> {{ $loan->interest_rate }} %</p>
        <p><strong>Statut :</strong> <span class="badge bg-primary">{{ $loan->status }}</span></p>
        <p><strong>Motif :</strong> {{ $loan->purpose }}</p>
    </div>
</div>
@endsection
