<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

// Gère les 2 liens "gagner des points" (Github + YouTube) demandés dans le
// cahier des charges : chaque lien ne rapporte des points qu'UNE seule fois
// par compte, grâce aux colonnes users.github_claimed / users.youtube_claimed.
class PointController extends Controller
{
    private const GITHUB_URL = 'https://github.com/020NyTsanta001';
    private const YOUTUBE_URL = 'https://www.youtube.com/';

    public function claimGithub(Request $request)
    {
        return $this->claim($request, 'github_claimed', self::GITHUB_URL);
    }

    public function claimYoutube(Request $request)
    {
        return $this->claim($request, 'youtube_claimed', self::YOUTUBE_URL);
    }

    private function claim(Request $request, string $flagColumn, string $redirectUrl)
    {
        $user = $request->user();

        // Déjà réclamé : on redirige simplement vers le lien, sans re-créditer.
        if ($user->{$flagColumn}) {
            return redirect()->away($redirectUrl);
        }

        // Le montant offert = le prix d'un ordinateur portable, pour permettre
        // à un compte de test d'effectuer un achat complet immédiatement.
        $points = 3000;

        $user->update([
            'points' => $user->points + $points,
            $flagColumn => true,
        ]);

        return redirect()->away($redirectUrl);
    }
}
