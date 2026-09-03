@extends('layouts.client')

@section('title', 'Mon panier — GamingStore')

@section('content')
<section>
    <div class="container">
        <h2 class="section-title">Mon panier</h2>

        @if ($items->isEmpty())
            <p class="text-muted">Votre panier est vide. <a href="{{ route('home') }}#produits" class="text-gradient">Voir les produits</a>.</p>
        @else
            <div class="table-responsive">
                <table class="table table-dark table-borderless align-middle">
                    <thead>
                        <tr class="text-muted">
                            <th>Produit</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Sous-total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item['product']->name }}</td>
                                <td>{{ $item['product']->price }} pts</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>{{ $item['product']->price * $item['qty'] }} pts</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item['product']) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Retirer</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <h4>Total : <span class="text-gradient">{{ $total }} pts</span></h4>
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <button class="btn btn-neon btn-lg">Valider l'achat</button>
                </form>
            </div>
            <p class="text-muted small mt-2">Votre solde actuel : {{ auth()->user()->points }} pts</p>
        @endif
    </div>
</section>
@endsection
