@extends('layouts.dashboard')

@section('title', 'Gestion financière')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Gestion financière</h2>
</div>

<div class="row mb-4">
    @foreach([
        ['Décaissé', number_format($disbursed, 2) . ' CDF', 'bank'],
        ['Remboursé', number_format($repaid, 2) . ' CDF', 'credit-card'],
        ['Pénalités', number_format($penalties, 2) . ' CDF', 'exclamation-circle'],
        ['Revenus', number_format($revenue, 2) . ' CDF', 'graph-up-arrow'],
    ] as $card)
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-{{ $card[2] }} fs-1" style="color:#3DFF7A;"></i>
                    <div class="mt-2 text-muted">{{ $card[0] }}</div>
                    <div class="fw-bold fs-5">{{ $card[1] }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    <div class="col-md-3 mb-3">
        <a href="{{ route('admin.financial.disbursements') }}" class="btn btn-outline-primary w-100">Décaissements</a>
    </div>
    <div class="col-md-3 mb-3">
        <a href="{{ route('admin.financial.repayments') }}" class="btn btn-outline-primary w-100">Remboursements</a>
    </div>
    <div class="col-md-3 mb-3">
        <a href="{{ route('admin.financial.penalties') }}" class="btn btn-outline-primary w-100">Pénalités</a>
    </div>
    <div class="col-md-3 mb-3">
        <a href="{{ route('admin.financial.revenue') }}" class="btn btn-outline-primary w-100">Revenus</a>
    </div>
</div>
@endsection
