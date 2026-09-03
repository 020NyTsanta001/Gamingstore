<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

// Contrôleur du visiteur / client. Ne touche jamais à la base autrement
// qu'en LECTURE : les produits affichés ici sont entièrement gérés par
// App\Http\Controllers\Admin\AdminProductController.
class HomeController extends Controller
{
    // Une seule page (/) qui contient toutes les sections demandées :
    // vidéo hero, intro + carousel, 6 ordinateurs, 6 accessoires, à propos.
    public function index(Request $request)
    {
        $search = $request->get('q');

        $laptops = Product::laptopsForClient();
        $accessories = Product::accessoriesForClient();

        if ($search) {
            $laptops = $laptops->filter(fn ($p) => str_contains(strtolower($p->name), strtolower($search)));
            $accessories = $accessories->filter(fn ($p) => str_contains(strtolower($p->name), strtolower($search)));
        }

        return view('client.home', compact('laptops', 'accessories', 'search'));
    }

    // Formulaire "à propos" -> message envoyé au propriétaire du site.
    // Version simulation : on se contente de rediriger avec un message flash
    // (aucun envoi de mail réel n'est requis par le cahier des charges).
    public function sendContact(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        return back()->with('success', 'Merci, votre message a bien été envoyé !');
    }
}
