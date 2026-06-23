@extends('layouts.dashboard')

@section('title', 'Détail du crédit')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Crédit {{ $loan->reference }}</h2>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Informations</h5>
                <p><strong>Montant demandé :</strong> {{ number_format($loan->amount_requested, 2) }} CDF</p>
                <p><strong>Montant approuvé :</strong> {{ number_format($loan->amount_approved ?? 0, 2) }} CDF</p>
                <p><strong>Durée :</strong> {{ $loan->duration_months }} mois</p>
                <p><strong>Taux :</strong> {{ $loan->interest_rate }} %</p>
                <p><strong>Statut :</strong> <span class="badge bg-primary">{{ $loan->status }}</span></p>
                <p><strong>Motif :</strong> {{ $loan->purpose }}</p>
                @if($loan->rejection_reason)
                    <p><strong>Motif du rejet :</strong> {{ $loan->rejection_reason }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        @if(in_array($loan->status, ['disbursed', 'running']))
            <a href="{{ route('client.repayments.create', $loan) }}" class="btn btn-success mb-3">Effectuer un remboursement</a>
        @endif
    </div>
</div>

@if($loan->schedules->isNotEmpty())
    <h4>Échéancier</h4>
    <div class="table-responsive">
        <table class="table table-sm table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date d'échéance</th>
                    <th>Principal</th>
                    <th>Intérêt</th>
                    <th>Total</th>
                    <th>Payé</th>
                    <th>Reste</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loan->schedules as $schedule)
                    <tr>
                        <td>{{ $schedule->installment_number }}</td>
                        <td>{{ $schedule->due_date->format('d/m/Y') }}</td>
                        <td>{{ number_format($schedule->principal_amount, 2) }}</td>
                        <td>{{ number_format($schedule->interest_amount, 2) }}</td>
                        <td>{{ number_format($schedule->total_amount, 2) }}</td>
                        <td>{{ number_format($schedule->paid_amount, 2) }}</td>
                        <td>{{ number_format($schedule->remaining_amount, 2) }}</td>
                        <td><span class="badge bg-{{ $schedule->status === 'paid' ? 'success' : ($schedule->status === 'overdue' ? 'danger' : 'warning') }}">{{ $schedule->status }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
