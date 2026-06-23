@extends('layouts.app')

@section('title', 'Double authentification')

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="auth-logo">
                            <div class="auth-logo-icon"></div>
                            {{ config('app.name') }}
                        </div>
                        <h4 class="mb-4 text-center">Vérification en deux étapes</h4>
                        <p class="text-center text-muted">Un code à 6 chiffres a été envoyé à votre email.</p>
                        <form method="POST" action="{{ route('two-factor.verify') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Code</label>
                                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" maxlength="6" required autofocus>
                                @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Vérifier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
