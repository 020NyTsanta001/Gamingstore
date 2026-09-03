@extends('layouts.admin')

@section('title', 'Produits — Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Ordinateurs & accessoires</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-neon">+ Nouveau produit</a>
</div>

<p class="text-muted small">
    Rappel : le site client n'affiche jamais que les <strong>6 derniers</strong> produits de chaque catégorie
    (voir <code>Product::laptopsForClient()</code> / <code>accessoriesForClient()</code>).
</p>

@foreach ([['label' => 'Ordinateurs portables', 'items' => $laptops], ['label' => 'Accessoires', 'items' => $accessories]] as $group)
    <h5 class="mt-4 mb-2">{{ $group['label'] }} ({{ $group['items']->count() }})</h5>
    <div class="admin-card p-3 mb-4">
        <table class="table align-middle mb-0">
            <thead>
                <tr class="text-muted">
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($group['items'] as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }} pts</td>
                        <td>
                            @if ($product->isOutOfStock())
                                <span class="badge bg-danger">Épuisé</span>
                            @else
                                {{ $product->stock }}
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce produit ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-muted">Aucun produit.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endforeach
@endsection
