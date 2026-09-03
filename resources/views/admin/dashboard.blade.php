@extends('layouts.admin')

@section('title', 'Tableau de bord — Admin')

@section('content')
<h2 class="fw-bold mb-4">Tableau de bord</h2>

<div class="row g-3">
    <div class="col-md-3">
        <div class="stat-card">
            <p class="text-muted mb-1">Clients</p>
            <p class="stat-value">{{ $stats['users'] }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p class="text-muted mb-1">Ordinateurs</p>
            <p class="stat-value">{{ $stats['laptops'] }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p class="text-muted mb-1">Accessoires</p>
            <p class="stat-value">{{ $stats['accessories'] }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <p class="text-muted mb-1">Commandes</p>
            <p class="stat-value">{{ $stats['orders'] }}</p>
        </div>
    </div>
</div>

<div class="mt-5">
    <p class="text-muted">
        Utilisez le menu à gauche pour gérer les comptes utilisateurs (CRUD complet),
        ajouter/modifier/supprimer des ordinateurs portables et accessoires, et consulter
        la liste des achats effectués par les clients.
    </p>
</div>
@endsection
