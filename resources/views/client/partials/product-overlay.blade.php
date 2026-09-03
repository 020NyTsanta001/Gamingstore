{{-- Overlay plein écran ouvert au clic sur la carte correspondante.
     Fermé par le bouton X, un clic hors-carte, ou la touche Échap. --}}
<div id="{{ $prefix }}-overlay-{{ $product->id }}" class="product-overlay">
    <div class="product-overlay-card">
        <button class="overlay-close" aria-label="Fermer">&times;</button>

        <img class="overlay-img" src="{{ $product->image ? asset('storage/'.$product->image) : 'https://picsum.photos/seed/'.$prefix.$product->id.'/700/700' }}" alt="{{ $product->name }}">

        <div class="overlay-body">
            <h3 class="text-gradient mb-3">{{ $product->name }}</h3>
            <p class="price fs-4 mb-3">{{ $product->price }} pts</p>

            <h6 class="text-muted mb-2">Configuration</h6>
            <p style="white-space: pre-line;">{{ $product->specs }}</p>

            <p class="text-muted small">Stock disponible : {{ $product->stock }}</p>

            @if ($product->isOutOfStock())
                <span class="badge badge-outofstock px-3 py-2">Stock épuisé</span>
            @else
                <form action="{{ route('cart.add', $product) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-neon">Ajouter au panier</button>
                </form>
            @endif
        </div>
    </div>
</div>
