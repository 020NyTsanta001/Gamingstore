@extends('layouts.client')

@section('title', 'Inscription — GamingStore')

@section('content')
<section class="d-flex align-items-center" style="min-height: 70vh;">
    <div class="container" style="max-width: 420px;">
        <h2 class="section-title">Créer un compte</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small text-muted">Nom</label>
                <input type="text" name="name" class="form-control search-form" value="{{ old('name') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label small text-muted">E-mail</label>
                <input type="email" name="email" class="form-control search-form" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label small text-muted">Mot de passe</label>
                <input type="password" name="password" class="form-control search-form" required>
            </div>
            <div class="mb-3">
                <label class="form-label small text-muted">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control search-form" required>
            </div>
            <button class="btn btn-neon w-100">S'inscrire</button>
        </form>

        <p class="text-muted small mt-3">Déjà un compte ? <a href="{{ route('login') }}" class="text-gradient">Connectez-vous</a></p>
    </div>
</section>
@endsection
