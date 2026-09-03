<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Appliqué sur le groupe de routes admin.* dans routes/web.php.
// Un client connecté qui tente d'accéder à /admin est simplement renvoyé
// vers l'accueil : seul un compte avec role = 'admin' passe.
class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        return $next($request);
    }
}
