@extends('layouts.dashboard')

@section('title', 'Rembourser un crédit')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Rembourser {{ $loan->reference }}</h2>
</div>

<div class="card">
    <div class="card-body">
        <p><strong>Solde restant :</strong> {{ number_format($loan->outstanding_balance, 2) }} CDF</p>
        <form method="POST" action="{{ route('client.repayments.store', $loan) }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Montant (CDF)</label>
                <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" required>
                @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Numéro mobile money</label>
                <input type="text" name="mobile_number" class="form-control @error('mobile_number') is-invalid @enderror" value="{{ old('mobile_number', auth()->user()->phone) }}" required>
                @error('mobile_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-success">Payer</button>
        </form>
    </div>
</div>
@endsection
