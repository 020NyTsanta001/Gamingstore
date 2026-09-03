<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Panier 100% simulé : stocké dans la session (clé 'cart' = [product_id => qty]).
// Aucun paiement réel : au checkout, on débite les "points" du compte client.
// C'est le seul contrôleur qui écrit dans orders / order_items côté client.
class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        if (! $request->user()) {
            return redirect()->route('login')->with('error', 'Connectez-vous pour acheter.');
        }

        if ($product->isOutOfStock()) {
            return back()->with('error', 'Ce produit est en rupture de stock.');
        }

        $cart = session('cart', []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + 1;
        session(['cart' => $cart]);

        return back()->with('success', $product->name.' ajouté au panier.');
    }

    public function remove(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return back();
    }

    public function show()
    {
        $cart = session('cart', []);
        $items = Product::whereIn('id', array_keys($cart))->get()
            ->map(fn ($p) => ['product' => $p, 'qty' => $cart[$p->id]]);

        $total = $items->sum(fn ($i) => $i['product']->price * $i['qty']);

        return view('client.cart', compact('items', 'total'));
    }

    // Transforme le panier de session en véritable commande (Order + OrderItem),
    // débite les points du client et décrémente le stock produit par produit.
    public function checkout(Request $request)
    {
        $user = $request->user();
        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Votre panier est vide.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();
        $total = $products->sum(fn ($p) => $p->price * $cart[$p->id]);

        if ($user->points < $total) {
            return back()->with('error', 'Points insuffisants pour cet achat.');
        }

        foreach ($products as $product) {
            if ($product->stock < $cart[$product->id]) {
                return back()->with('error', "Stock épuisé pour {$product->name}.");
            }
        }

        DB::transaction(function () use ($user, $products, $cart, $total) {
            $order = Order::create(['user_id' => $user->id, 'total_points' => $total]);

            foreach ($products as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $product->price,
                    'quantity' => $cart[$product->id],
                ]);

                $product->decrement('stock', $cart[$product->id]);
            }

            $user->decrement('points', $total);
        });

        session()->forget('cart');

        return redirect()->route('profile')->with('success', 'Achat confirmé, merci !');
    }
}
