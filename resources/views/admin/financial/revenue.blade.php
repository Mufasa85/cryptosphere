@extends('layouts.dashboard')

@section('title', 'Revenus')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Revenus</h2>
</div>

<div class="row mb-4">
    @foreach([
        ['Intérêts perçus', number_format($interest, 2) . ' CDF', 'graph-up'],
        ['Pénalités payées', number_format($penalties, 2) . ' CDF', 'exclamation-circle'],
        ['Revenus total', number_format($revenue, 2) . ' CDF', 'cash-stack'],
    ] as $card)
        <div class="col-md-4 mb-3">
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
@endsection
