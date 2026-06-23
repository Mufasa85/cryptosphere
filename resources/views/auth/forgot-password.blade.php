@extends('layouts.app')

@section('title', 'Mot de passe oublié')

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
                        <h4 class="mb-4 text-center">Mot de passe oublié</h4>
                        <p class="text-center text-muted">Entrez votre email pour recevoir un lien de réinitialisation.</p>
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Envoyer le lien</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="{{ route('login') }}">Retour à la connexion</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
