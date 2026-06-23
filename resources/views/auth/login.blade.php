@extends('layouts.app')

@section('title', 'Connexion')

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
                        <h4 class="mb-4 text-center">Connexion</h4>
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                <label class="form-check-label" for="remember">Se souvenir de moi</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="{{ route('password.request') }}">Mot de passe oublié ?</a><br>
                            <a href="{{ route('register') }}">Créer un compte</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
