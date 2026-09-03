@extends('layouts.client')

@section('title', 'Connexion — GamingStore')

@section('content')
<section class="d-flex align-items-center" style="min-height: 70vh;">
    <div class="container" style="max-width: 420px;">
        <h2 class="section-title">Connexion</h2>

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small text-muted">E-mail</label>
                <input type="email" name="email" class="form-control search-form" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label small text-muted">Mot de passe</label>
                <input type="password" name="password" class="form-control search-form" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label small text-muted" for="remember">Se souvenir de moi</label>
            </div>
            <button class="btn btn-neon w-100">Se connecter</button>
        </form>

        <p class="text-muted small mt-3">Pas encore de compte ? <a href="{{ route('register') }}" class="text-gradient">Inscrivez-vous</a></p>

        
    </div>
</section>
@endsection
