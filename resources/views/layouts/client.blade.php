<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'GamingStore — Ordinateurs portables gaming & accessoires')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    
</head>
<body class="d-flex flex-column min-vh-100">

{{-- ============================= NAVBAR ============================= --}}
<nav class="navbar navbar-expand-lg navbar-gaming fixed-top py-3">
    <div class="container">
        <a class="navbar-brand text-gradient fs-4 d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="GamingStore" height="38">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav mx-auto gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#accueil">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#produits">Ordinateurs & accessoires</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}#apropos">À propos</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ auth()->check() ? route('profile') : route('login') }}">Compte</a>
                </li>
            </ul>

            <form action="{{ route('home') }}" method="GET" class="search-form d-flex me-lg-3 mt-3 mt-lg-0">
                <input type="search" name="q" value="{{ request('q') }}" class="form-control rounded-pill" placeholder="Rechercher un produit...">
            </form>

            @auth
                <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                    <a href="{{ route('cart.show') }}" class="btn btn-outline-neon btn-sm">🛒 Panier</a>
                    <span class="text-cyan small text-nowrap" style="color:var(--cyan)">{{ auth()->user()->points }} pts</span>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-neon btn-sm mt-3 mt-lg-0">Connexion</a>
            @endauth
        </div>
    </div>
</nav>

<main class="flex-grow-1" style="padding-top: 84px;">
    @if (session('success'))
        <div class="container mt-3">
            <div class="alert alert-success">{{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger">{{ session('error') }}</div>
        </div>
    @endif

    @yield('content')
</main>

{{-- ============================= FOOTER ============================= --}}
<footer class="site-footer text-center">
    <div class="container">
        &copy; {{ date('Y') }} GamingStore de NyTs — Tous droits réservés.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>
