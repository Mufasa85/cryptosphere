@extends('layouts.dashboard')

@section('title', 'Nouvelle demande')

@section('dashboard-content')
<div class="pt-3 pb-2 mb-3 border-bottom">
    <h2>Nouvelle demande de crédit</h2>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('client.loans.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Montant demandé (CDF)</label>
                <input type="number" step="0.01" name="amount_requested" class="form-control @error('amount_requested') is-invalid @enderror" value="{{ old('amount_requested') }}" required>
                @error('amount_requested')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Durée (mois)</label>
                <input type="number" name="duration_months" class="form-control @error('duration_months') is-invalid @enderror" value="{{ old('duration_months', 12) }}" required>
                @error('duration_months')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Taux d'intérêt (%)</label>
                <input type="number" step="0.01" name="interest_rate" class="form-control @error('interest_rate') is-invalid @enderror" value="{{ old('interest_rate', 5) }}" required>
                @error('interest_rate')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Motif</label>
                <textarea name="purpose" rows="4" class="form-control @error('purpose') is-invalid @enderror" required>{{ old('purpose') }}</textarea>
                @error('purpose')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Soumettre</button>
        </form>
    </div>
</div>
@endsection
