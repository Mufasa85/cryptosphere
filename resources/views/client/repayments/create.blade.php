@extends('layouts.dashboard')

@section('title', 'Rembourser un crédit')

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
</style>

<div class="at-root">

    <div class="at-page-header">
        <div>
            <h1 class="at-page-title">Rembourser le crédit</h1>
            <p class="at-page-subtitle">Référence : <span class="at-ref">{{ $loan->reference }}</span></p>
        </div>
        <a href="{{ route('client.loans.show', $loan) }}" class="at-btn at-btn-ghost at-btn-sm">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Retour
        </a>
    </div>

    {{-- Solde restant --}}
    <div class="at-stat-grid" style="margin-bottom:20px;">
        <div class="at-stat-card">
            <div class="at-stat-icon at-stat-icon-orange">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div>
                <div class="at-stat-label">Solde restant à rembourser</div>
                <div class="at-stat-value">{{ number_format($loan->outstanding_balance, 2) }} <span style="font-size:.75rem;color:var(--muted);">CDF</span></div>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div style="background:rgba(255,107,107,.1);border:1px solid rgba(255,107,107,.25);border-radius:12px;padding:14px 18px;margin-bottom:20px;">
            <div style="color:var(--danger);font-weight:600;font-size:.85rem;margin-bottom:6px;">Erreur :</div>
            <ul style="margin:0;padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li style="color:var(--danger);font-size:.85rem;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="at-card" style="padding:28px 32px;max-width:520px;">
        <form method="POST" action="{{ route('client.repayments.store', $loan) }}">
            @csrf
            <div class="at-form-group">
                <label class="at-form-label">Montant à payer (CDF)</label>
                <input type="number" step="0.01" name="amount" class="at-form-input @error('amount') is-invalid @enderror" placeholder="Montant en CDF" value="{{ old('amount', $loan->outstanding_balance) }}" required>
                @error('amount')<div class="at-form-error">{{ $message }}</div>@enderror
            </div>
            <div class="at-form-group">
                <label class="at-form-label">Numéro Mobile Money</label>
                <input type="text" name="mobile_number" class="at-form-input @error('mobile_number') is-invalid @enderror" placeholder="Ex: +243XXXXXXXXX" value="{{ old('mobile_number', auth()->user()->phone) }}" required>
                @error('mobile_number')<div class="at-form-error">{{ $message }}</div>@enderror
            </div>
            <div style="margin-top:28px;">
                <button type="submit" class="at-btn at-btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Confirmer le paiement
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
