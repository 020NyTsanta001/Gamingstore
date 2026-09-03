# Cahier des charges — Construction de GamingStore (Laravel 12)

Ce document décrit **l'ordre exact** dans lequel construire le projet,
étape par étape, avec à chaque fois : ce qu'on fait, pourquoi on le fait
à ce moment précis, et comment on vérifie que ça fonctionne avant de
passer à la suite.

---

## Phase 0 — Préparation de l'environnement
**Objectif : avoir un projet Laravel 12 vide qui tourne, avant d'écrire la moindre ligne métier.**

| # | Étape |
|---|-------|
| 0.1 | Installer XAMPP, démarrer Apache + MySQL |
| 0.2 | Créer la base vide `gamingstore` dans phpMyAdmin |
| 0.3 | `composer create-project laravel/laravel gamingstore` |
| 0.4 | lancer `php artisan migrate --seed`puis `php artisan key:generate` |
| 0.5 | `php artisan serve` |

**✅ Test de fin de phase :** ouvrir `http://localhost:8000` → la page
d'accueil par défaut de Laravel s'affiche, sans erreur 500. Si ça ne
marche pas ici, rien de ce qui suit ne pourra fonctionner : on ne
continue pas tant que ce test n'est pas vert.

---

## Phase 1 — Base de données (migrations)
**Objectif : la structure des tables existe et est valide, avant d'écrire le moindre contrôleur.**

On construit toujours la BDD **avant** les modèles, et les modèles
**avant** les contrôleurs — jamais l'inverse, sinon on code à l'aveugle
sur des colonnes qui n'existent pas encore.

| # | Étape |
|---|-------|
| 1.1 | Migration `users` (ajout des colonnes `role`, `points`, `github_claimed`, `youtube_claimed`) |
| 1.2 | Migration `products` (`type`, `name`, `specs`, `price`, `stock`, `image`) |
| 1.3 | Migration `orders` (`user_id`, `total_points`) |
| 1.4 | Migration `order_items` (`order_id`, `product_id`, `product_name`, `unit_price`, `quantity`) |
| 1.5 | `php artisan migrate` |

**✅ Test de fin de phase :** dans phpMyAdmin, les 4 tables existent
avec les bonnes colonnes et les bonnes clés étrangères (`orders.user_id`
→ `users.id`, `order_items.order_id` → `orders.id`,
`order_items.product_id` → `products.id`). Si une clé étrangère échoue à
la migration, on corrige ici — pas plus tard.

---

## Phase 2 — Modèles Eloquent
**Objectif : pouvoir manipuler les données en PHP, testé en isolation via Tinker, avant toute vue ou route.**

| # | Étape |
|---|-------|
| 2.1 | `App\Models\User` (`fillable`, `casts`, méthode `isAdmin()`, relation `orders()`) |
| 2.2 | `App\Models\Product` (`fillable`, `isOutOfStock()`, `laptopsForClient()`, `accessoriesForClient()`) |
| 2.3 | `App\Models\Order` + `App\Models\OrderItem` (relations `belongsTo`/`hasMany`) |
| 2.4 | Seeder `DatabaseSeeder` (1 admin, 1 client de test, 6 laptops, 6 accessoires) |
| 2.5 | `php artisan migrate --seed` |

**✅ Test de fin de phase :** `php artisan tinker`, puis :
```php
User::where('role','admin')->first();      // doit renvoyer l'admin
Product::laptopsForClient()->count();       // doit renvoyer 6
```
Si ces deux lignes ne renvoient pas le résultat attendu, on corrige le
modèle ou le seeder avant de toucher au moindre contrôleur.

---

## Phase 3 — Authentification (avant tout le reste du métier)
**Objectif : savoir qui est connecté, car TOUT le reste (panier, points, admin) en dépend.**

| # | Étape |
|---|-------|
| 3.1 | `App\Http\Controllers\Auth\AuthController` (login, register, logout) |
| 3.2 | Vues `auth/login.blade.php`, `auth/register.blade.php` (version brute, sans design) |
| 3.3 | Routes `/connexion`, `/inscription`, `/deconnexion` |
| 3.4 | `App\Http\Middleware\IsAdmin` + alias `admin` dans `bootstrap/app.php` |

**✅ Test de fin de phase (manuel, dans le navigateur) :**
- Se connecter avec `client@gamingstore.test` → redirigé vers `/compte`
- Se connecter avec `admin@gamingstore.test` → redirigé vers `/admin`
- Se déconnecter → retour à l'accueil, routes protégées inaccessibles
- Essayer d'atteindre `/admin` en étant connecté en client → erreur 403

On ne passe à la phase 4 que si ces 4 scénarios fonctionnent.

---

## Phase 4 — Back-office admin (avant le front client)
**Pourquoi l'admin avant le client ?** Parce que le site client affiche
des produits — il faut donc un moyen de les créer *avant* de pouvoir
tester l'affichage client avec de vraies données (autres que le seeder).

| # | Étape | Test associé (à faire immédiatement après, pas à la fin) |
|---|-------|------------------------------------------------------------|
| 4.1 | `AdminUserController` (CRUD complet) + vues `admin/users/*` | Créer un compte, le modifier, le supprimer → vérifier en BDD à chaque action |
| 4.2 | `AdminProductController` (CRUD) + vues `admin/products/*` | Ajouter un ordinateur avec photo → vérifier qu'il apparaît dans `storage/app/public/products` (après `php artisan storage:link`) |
| 4.3 | `AdminOrderController` (lecture seule) + vue `admin/orders/index.blade.php` | Vide pour l'instant — normal, aucune commande n'existe encore (testé en phase 5) |
| 4.4 | `AdminDashboardController` + vue dashboard | Les compteurs (clients, laptops, accessoires, commandes) correspondent aux chiffres réels en BDD |
| 4.5 | Layout `admin.blade.php` (mode clair, sidebar) | Navigation entre les 4 sections sans rechargement cassé |

**✅ Test de fin de phase :** un admin peut faire un CRUD complet sur les
comptes et les produits sans passer par Tinker ni phpMyAdmin. C'est le
jalon le plus important du projet : si l'admin ne peut pas alimenter les
produits, le client n'aura rien à afficher.

---

## Phase 5 — Front-end client
**Objectif : construire la page publique, section par section, dans l'ordre où l'utilisateur les voit.**

À ce stade, la BDD contient déjà de vrais produits ajoutés en phase 4 —
on ne teste donc jamais l'affichage sur des données vides.

| # | Étape | Test associé |
|---|-------|--------------|
| 5.1 | `HomeController@index` + layout `client.blade.php` (navbar sticky, recherche, footer) | La navbar reste visible au scroll, le lien "Compte" pointe vers login ou profil selon connexion |
| 5.2 | Section hero vidéo en boucle | La vidéo se lance automatiquement, en boucle, muette (`autoplay muted loop`) |
| 5.3 | Section intro 3/4 + carousel 1/4 | Les 4 images alternent bien toutes les 4 secondes (`public/js/app.js`) |
| 5.4 | Grille des 6 ordinateurs (`product-card.blade.php`) | Exactement 6 cartes, 3 par ligne en desktop, prix et bouton "Ajouter au panier" corrects |
| 5.5 | Overlay produit agrandi (`product-overlay.blade.php`) | Clic sur une carte → overlay plein écran avec photo à gauche / specs à droite ; le X et Échap ferment ; le clic sur le bouton panier n'ouvre pas l'overlay |
| 5.6 | Grille des 6 accessoires (même mécanique) | Même comportement que 5.4/5.5, indépendant des ordinateurs |
| 5.7 | Section à propos (3 colonnes + formulaire contact) | Le formulaire envoie une requête POST et affiche le message de succès |
| 5.8 | `public/css/custom.css` (thème violet/cyan-rose, Poppins, boutons, scrollbar) | Vérification visuelle sur desktop et mobile (responsive Bootstrap) |

**✅ Test de fin de phase :** parcourir la page de haut en bas sans
être connecté → tout s'affiche correctement, seul le clic sur "Ajouter
au panier" doit rediriger vers la connexion (comportement attendu, testé
en phase 6).

---

## Phase 6 — Panier, points, achat (le cœur de la logique métier)
**Objectif : la boucle complète client → achat → admin, testée de bout en bout.**

C'est la phase la plus sensible : chaque étape modifie l'état de la
BDD (stock, points), donc on teste **après chaque sous-étape**, pas
seulement à la fin.

| # | Étape | Test associé |
|---|-------|--------------|
| 6.1 | `PointController` (liens Github/YouTube) | Cliquer une 1ère fois → points crédités ; cliquer une 2e fois → aucun point supplémentaire, `github_claimed`/`youtube_claimed` passés à `true` en BDD |
| 6.2 | `CartController@add` / `remove` / `show` (panier en session) | Ajouter 2 produits différents, vérifier `/panier` affiche bien le bon total ; retirer un produit, vérifier la mise à jour |
| 6.3 | `CartController@checkout` (transaction BDD) | Cas 1 : points suffisants → commande créée, stock décrémenté, points débités. Cas 2 : points insuffisants → message d'erreur, rien n'est modifié en BDD (vérifier avec une transaction ratée volontairement) |
| 6.4 | Règle stock épuisé | Acheter un produit jusqu'à stock = 0 → le bouton "Ajouter au panier" est remplacé par le badge "Stock épuisé" sur le prochain chargement de page |
| 6.5 | Vue `client/profile.blade.php` | Le solde de points, l'historique des achats et les boutons de gain de points reflètent exactement l'état réel du compte |
| 6.6 | Vérification côté admin | Retourner sur `/admin/commandes` → la commande passée en 6.3 apparaît avec le bon client, le bon produit, le bon total |

**✅ Test de fin de phase (scénario complet, à rejouer intégralement) :**
1. Créer un nouveau compte client
2. Cliquer les 2 liens de points
3. Acheter un ordinateur portable
4. Vérifier le stock décrémenté côté admin
5. Vérifier la commande visible dans `/admin/commandes`
6. Retenter les 2 liens de points → aucun gain supplémentaire

Si ce scénario complet passe sans erreur, la relation
**client → admin → achat** est validée de bout en bout.

---

## Phase 7 — Tests transversaux et finitions
**Objectif : robustesse et cohérence globale, une fois toutes les fonctionnalités posées.**

| # | Étape |
|---|-------|
| 7.1 | Tester tous les cas d'erreurs de formulaire (email déjà pris, mot de passe trop court, champs vides) sur inscription, login, CRUD admin |
| 7.2 | Tester les accès non autorisés : client sur `/admin/*`, visiteur non connecté sur `/panier` ou `/compte` |
| 7.3 | Vérifier le responsive (mobile/tablette) sur la page client (navbar, overlay, grille produits) |
| 7.4 | Vérifier que la recherche (`?q=`) filtre correctement les produits affichés |
| 7.5 | Relire chaque contrôleur et vérifier que son commentaire d'en-tête correspond bien à son rôle réel (documentation à jour) |

**✅ Test de fin de phase :** faire tester le site par une deuxième
personne sans lui expliquer le code — si elle comprend seule le parcours
client et retrouve l'admin sans aide, le site est considéré "lisible et
autonome", ce qui était l'objectif du cahier des charges initial.

---

## Phase 8 — Mise en situation finale / livraison
| # | Étape |
|---|-------|
| 8.1 | `php artisan migrate:fresh --seed` sur un environnement propre pour valider que tout se reconstruit depuis zéro sans erreur |
| 8.2 | Relecture complète de `routes/web.php` (aucune route orpheline, aucun contrôleur non utilisé) |
| 8.3 | Vérifier que `.env` réel n'est jamais commité (présent dans `.gitignore`) |
| 8.4 | Rédiger/mettre à jour le README avec les identifiants de démo |

**✅ Test final :** un tiers qui clone le projet, suit uniquement le
README, doit arriver à un site fonctionnel en moins de 10 minutes, sans
poser de question.

---

## Résumé — pourquoi cet ordre et pas un autre

```
BDD (Phase 1) → Modèles (Phase 2) → Auth (Phase 3)
      → Admin/CRUD produits (Phase 4)   [on a besoin de données réelles]
      → Front client (Phase 5)          [on affiche ces données]
      → Panier/points/achat (Phase 6)   [logique qui relie client ↔ admin]
      → Tests transversaux (Phase 7)
      → Livraison (Phase 8)
```


