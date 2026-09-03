<div class="mb-3">
    <label class="form-label">Catégorie</label>
    <select name="type" class="form-select" required>
        <option value="laptop" {{ old('type', $product->type ?? '') == 'laptop' ? 'selected' : '' }}>Ordinateur portable</option>
        <option value="accessory" {{ old('type', $product->type ?? '') == 'accessory' ? 'selected' : '' }}>Accessoire</option>
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Nom</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Configuration / description (specs)</label>
    <textarea name="specs" rows="4" class="form-control" required>{{ old('specs', $product->specs ?? '') }}</textarea>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Prix (points)</label>
        <input type="number" name="price" min="1" class="form-control" value="{{ old('price', $product->price ?? '') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Stock</label>
        <input type="number" name="stock" min="0" class="form-control" value="{{ old('stock', $product->stock ?? 0) }}" required>
    </div>
</div>
<div class="mb-3">
    <label class="form-label">Photo</label>
    <input type="file" name="image" class="form-control" accept="image/*">
    @isset($product)
        @if ($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" class="mt-2" style="height:80px; border-radius:8px;">
        @endif
    @endisset
</div>
<button class="btn btn-neon">Enregistrer</button>
