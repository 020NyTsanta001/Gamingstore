@extends('layouts.client')

@section('content')

{{-- ===================== HERO VIDÉO EN BOUCLE ===================== --}}
<div id="accueil" class="hero-video-wrapper">
    <video autoplay muted loop playsinline>
        {{-- Remplacez par votre propre vidéo dans public/videos/hero.mp4 --}}
        <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">
    </video>
    <div class="hero-video-overlay">
        <h1>Équipez votre <span class="text-gradient">setup gaming</span></h1>
        <p class="text-muted fs-5 mb-4">Ordinateurs portables & accessoires gaming, sélectionnés pour la performance.</p>
        <a href="#produits" class="btn btn-neon btn-lg">Découvrir les produits</a>
    </div>
</div>

{{-- ===================== INTRO 3/4 + CAROUSEL 1/4 ===================== --}}
<section>
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-9">
                <h2 class="section-title">Bienvenue sur GamingStore</h2>
                <p class="text-muted fs-5">
                    GamingStore est une boutique pensée pour les joueurs : nous sélectionnons des ordinateurs
                    portables gaming puissants et des accessoires fiables, à des prix simulés en points pour
                    vous permettre de tester toute l'expérience d'achat sans dépenser un centime réel.
                    Parcourez le catalogue, cliquez sur un produit pour voir sa fiche complète, et ajoutez-le
                    à votre panier en un clic.
                </p>
            </div>
            <div class="col-lg-3">
                <div class="intro-carousel-frame">
                    <img src="{{ asset('images/2.jpg') }}" class="intro-carousel-img active" alt="Setup gaming 1">
                    <img src="{{ asset('images/5.jpg') }}" class="intro-carousel-img" alt="Setup gaming 2">
                    <img src="{{ asset('images/9.jpg') }}" class="intro-carousel-img" alt="Setup gaming 3">
                    <img src="{{ asset('images/12.jpg') }}" class="intro-carousel-img" alt="Setup gaming 4">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== ORDINATEURS PORTABLES ===================== --}}
<section id="produits">
    <div class="container">
        <h2 class="section-title">Ordinateurs portables gaming</h2>

        @if ($laptops->isEmpty())
            <p class="text-muted">Aucun ordinateur disponible pour le moment.</p>
        @endif

        <div class="row g-4">
            @foreach ($laptops as $laptop)
                @include('client.partials.product-card', ['product' => $laptop, 'prefix' => 'laptop'])
            @endforeach
        </div>
    </div>
</section>

{{-- ===================== ACCESSOIRES ===================== --}}
<section>
    <div class="container">
        <h2 class="section-title">Accessoires gaming</h2>

        @if ($accessories->isEmpty())
            <p class="text-muted">Aucun accessoire disponible pour le moment.</p>
        @endif

        <div class="row g-4">
            @foreach ($accessories as $accessory)
                @include('client.partials.product-card', ['product' => $accessory, 'prefix' => 'accessory'])
            @endforeach
        </div>
    </div>
</section>

{{-- ===================== OVERLAYS (fiches produits agrandies) ===================== --}}
@foreach ($laptops as $laptop)
    @include('client.partials.product-overlay', ['product' => $laptop, 'prefix' => 'laptop'])
@endforeach
@foreach ($accessories as $accessory)
    @include('client.partials.product-overlay', ['product' => $accessory, 'prefix' => 'accessory'])
@endforeach

{{-- ===================== À PROPOS (3 colonnes) ===================== --}}
<section id="apropos">
    <div class="container">
        <h2 class="section-title">À propos</h2>
        <div class="row g-5">
            <div class="col-md-4 text-center text-md-start">
                <img src="https://picsum.photos/seed/portrait/400/400" class="about-photo" alt="Photo du créateur du site">
            </div>

            <div class="col-md-4">
                <h5 class="text-gradient">Qui suis-je ?</h5>
                <p class="text-muted">
                    Développeur passionné de gaming et de web, j'ai conçu GamingStore comme projet de
                    démonstration Laravel : gestion des comptes, des produits et des commandes, du
                    formulaire d'ajout côté admin jusqu'à l'affichage et l'achat côté client.
                </p>
            </div>

            <div class="col-md-4">
                <h5 class="text-gradient">Contact</h5>
                <p class="text-muted mb-1">nytsantaf@gmail.com</p>
                <form action="{{ route('contact.send') }}" method="POST" class="mt-3">
                    @csrf
                    <div class="mb-2">
                        <input type="email" name="email" class="form-control search-form" placeholder="Votre e-mail" required>
                    </div>
                    <div class="mb-2">
                        <textarea name="message" rows="3" class="form-control search-form" placeholder="Votre message" required></textarea>
                    </div>
                    <button class="btn btn-neon w-100">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
