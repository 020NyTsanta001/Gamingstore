@extends('layouts.client')

@section('title', 'Mon compte — GamingStore')

@section('content')
<section>
    <div class="container">
        <h2 class="section-title">Mon compte</h2>

        <div class="row g-4">
            {{-- Points & gain de points --}}
            <div class="col-lg-4">
                <div class="p-4" style="background:var(--bg-card); border-radius:14px; border:1px solid rgba(139,92,246,.25);">
                    <h5 class="text-muted mb-1">Solde de points</h5>
                    <p class="display-6 text-gradient fw-bold">{{ $user->points }} pts</p>

                    <hr style="border-color: rgba(139,92,246,.25)">

                    <h6 class="text-muted">Gagner des points</h6>
                    <p class="small text-muted">Chaque lien ne rapporte des points qu'une seule fois.</p>

                    <a href="{{ route('points.github') }}" class="btn btn-outline-neon w-100 mb-2">
                        {{ $user->github_claimed ? '✔ Github déjà réclamé' : '⭐ Visiter mon Github' }}
                    </a>
                    <a href="{{ route('points.youtube') }}" class="btn btn-outline-neon w-100">
                        {{ $user->youtube_claimed ? '✔ YouTube déjà réclamé' : '▶ Visiter ma chaîne YouTube' }}
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="mt-4">
                        @csrf
                        <button class="btn btn-neon w-100">Déconnexion</button>
                    </form>
                </div>
            </div>

            {{-- Paramètres du compte --}}
            <div class="col-lg-4">
                <div class="p-4" style="background:var(--bg-card); border-radius:14px; border:1px solid rgba(139,92,246,.25);">
                    <h5 class="text-muted mb-3">Paramètres du compte</h5>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label small text-muted">Nom</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control search-form" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted">E-mail</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control search-form" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted">Nouveau mot de passe (facultatif)</label>
                            <input type="password" name="password" class="form-control search-form">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-control search-form">
                        </div>
                        <button class="btn btn-neon w-100">Mettre à jour</button>
                    </form>
                </div>
            </div>

            {{-- Historique des achats --}}
            <div class="col-lg-4">
                <div class="p-4" style="background:var(--bg-card); border-radius:14px; border:1px solid rgba(139,92,246,.25); max-height: 420px; overflow-y:auto;">
                    <h5 class="text-muted mb-3">Mes achats</h5>

                    @forelse ($user->orders as $order)
                        <div class="mb-3 pb-3" style="border-bottom:1px solid rgba(255,255,255,.08)">
                            <p class="small text-muted mb-1">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            @foreach ($order->items as $item)
                                <p class="mb-0 small">{{ $item->quantity }} × {{ $item->product_name }} — {{ $item->unit_price }} pts</p>
                            @endforeach
                            <p class="fw-bold small mt-1">Total : {{ $order->total_points }} pts</p>
                        </div>
                    @empty
                        <p class="text-muted small">Aucun achat pour le moment.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
