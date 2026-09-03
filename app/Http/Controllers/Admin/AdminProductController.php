<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

// CRUD des produits (ordinateurs portables ET accessoires, distingués par
// la colonne "type"). C'est ici, et uniquement ici, que sont saisis
// photo / config / prix / stock : voir Product::laptopsForClient() et
// accessoriesForClient() pour la règle "max 6 affichés côté client".
class AdminProductController extends Controller
{
    public function index()
    {
        $laptops = Product::where('type', 'laptop')->latest()->get();
        $accessories = Product::where('type', 'accessory')->latest()->get();

        return view('admin.products.index', compact('laptops', 'accessories'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produit ajouté.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Produit supprimé.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'type' => ['required', 'in:laptop,accessory'],
            'name' => ['required', 'string', 'max:255'],
            'specs' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:1'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);
    }
}
