@extends('layouts.dashboard')

@section('title', 'Nouvelle demande')

@section('dashboard-content')
@include('layouts.partials.agent-table-styles')

<style>
.at-form-group { margin-bottom: 20px; }
.at-form-label { display:block; font-size:.8rem; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:.5px; margin-bottom:8px; }
.at-form-input {
    width:100%; padding:11px 14px;
    background:var(--bg-secondary); border:1px solid var(--border);
    border-radius:10px; color:var(--text); font-family:'Inter',sans-serif;
    font-size:.9rem; outline:none; transition:border-color .2s,box-shadow .2s;
}
.at-form-input:focus { border-color:var(--glow); box-shadow:0 0 0 3px rgba(0,196,90,.15); }
.at-form-input.is-invalid { border-color:var(--danger); }
.at-form-input::placeholder { color:var(--muted); }
.at-form-error { color:var(--danger); font-size:.8rem; margin-top:5px; }
textarea.at-form-input { resize:vertical; min-height:100px; }
</style>

<div class="at-root">

    <div class="at-page-header">
        <div>
            <h1 class="at-page-title">Nouvelle demande de crédit</h1>
            <p class="at-page-subtitle">Remplissez le formulaire ci-dessous</p>
        </div>
        <a href="{{ route('client.loans.index') }}" class="at-btn at-btn-ghost at-btn-sm">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Retour
        </a>
    </div>

    @if($errors->any())
        <div style="background:rgba(255,107,107,.1);border:1px solid rgba(255,107,107,.25);border-radius:12px;padding:14px 18px;margin-bottom:20px;">
            <div style="color:var(--danger);font-weight:600;font-size:.85rem;margin-bottom:6px;">Veuillez corriger les erreurs suivantes :</div>
            <ul style="margin:0;padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li style="color:var(--danger);font-size:.85rem;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="at-card" style="padding:28px 32px;max-width:640px;">
        <form method="POST" action="{{ route('client.loans.store') }}">
            @csrf
            <div class="at-form-group">
                <label class="at-form-label">Montant demandé (CDF)</label>
                <input type="number" step="0.01" name="amount_requested" class="at-form-input @error('amount_requested') is-invalid @enderror" placeholder="Ex: 500000" value="{{ old('amount_requested') }}" required>
                @error('amount_requested')<div class="at-form-error">{{ $message }}</div>@enderror
            </div>
            <div class="at-form-group">
                <label class="at-form-label">Durée (mois)</label>
                <input type="number" name="duration_months" class="at-form-input @error('duration_months') is-invalid @enderror" placeholder="Ex: 12" value="{{ old('duration_months', 12) }}" required>
                @error('duration_months')<div class="at-form-error">{{ $message }}</div>@enderror
            </div>
            <div class="at-form-group">
                <label class="at-form-label">Taux d'intérêt (%)</label>
                <input type="number" step="0.01" name="interest_rate" class="at-form-input @error('interest_rate') is-invalid @enderror" placeholder="Ex: 5" value="{{ old('interest_rate', 5) }}" required>
                @error('interest_rate')<div class="at-form-error">{{ $message }}</div>@enderror
            </div>
            <div class="at-form-group">
                <label class="at-form-label">Motif de la demande</label>
                <textarea name="purpose" class="at-form-input @error('purpose') is-invalid @enderror" placeholder="Décrivez l'objet de votre demande…" required>{{ old('purpose') }}</textarea>
                @error('purpose')<div class="at-form-error">{{ $message }}</div>@enderror
            </div>
            <div style="margin-top:28px;">
                <button type="submit" class="at-btn at-btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Soumettre la demande
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
