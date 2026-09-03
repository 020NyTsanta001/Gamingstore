<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\PointController;
use App\Http\Controllers\Client\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CÔTÉ CLIENT (public) — App\Http\Controllers\Client\*
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| AUTHENTIFICATION — App\Http\Controllers\Auth\AuthController
|--------------------------------------------------------------------------
*/
Route::get('/connexion', [AuthController::class, 'showLogin'])->name('login');
Route::post('/connexion', [AuthController::class, 'login']);
Route::get('/inscription', [AuthController::class, 'showRegister'])->name('register');
Route::post('/inscription', [AuthController::class, 'register']);
Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ESPACE CLIENT CONNECTÉ — panier, points, profil
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/panier', [CartController::class, 'show'])->name('cart.show');
    Route::post('/panier/ajouter/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/panier/retirer/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/panier/valider', [CartController::class, 'checkout'])->name('cart.checkout');

    Route::get('/compte', [ProfileController::class, 'show'])->name('profile');
    Route::put('/compte', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/points/github', [PointController::class, 'claimGithub'])->name('points.github');
    Route::get('/points/youtube', [PointController::class, 'claimYoutube'])->name('points.youtube');
});

/*
|--------------------------------------------------------------------------
| CÔTÉ ADMIN (back-office) — App\Http\Controllers\Admin\*
| Protégé par le middleware "admin" (App\Http\Middleware\IsAdmin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('utilisateurs', AdminUserController::class)
        ->parameters(['utilisateurs' => 'user'])
        ->names('users');

    Route::resource('produits', AdminProductController::class)
        ->parameters(['produits' => 'product'])
        ->names('products');

    Route::get('/commandes', [AdminOrderController::class, 'index'])->name('orders.index');
});
