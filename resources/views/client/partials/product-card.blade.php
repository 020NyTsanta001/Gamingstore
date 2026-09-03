{{-- Une carte produit cliquable : le clic sur la carte ouvre l'overlay
     #{{ $prefix }}-overlay-{{ $product->id }} (voir public/js/app.js). --}}
<div class="col-md-6 col-lg-4">
    <div class="product-card" data-overlay-target="{{ $prefix }}-overlay-{{ $product->id }}">
        <img src="{{ $product->image ? asset('storage/'.$product->image) : 'https://picsum.photos/seed/'.$prefix.$product->id.'/500/350' }}" alt="{{ $product->name }}">
        <div class="card-body">
            <h5 class="mb-1">{{ $product->name }}</h5>
            <p class="price mb-3">{{ $product->price }} pts</p>

            @if ($product->isOutOfStock())
                <span class="badge badge-outofstock px-3 py-2 w-100">Stock épuisé</span>
            @else
                <form action="{{ route('cart.add', $product) }}" method="POST" class="js-add-to-cart">
                    @csrf
                    <button type="submit" class="btn btn-outline-neon w-100">Ajouter au panier</button>
                </form>
            @endif
        </div>
    </div>
</div>
