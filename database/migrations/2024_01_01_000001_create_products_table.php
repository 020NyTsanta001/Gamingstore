<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Un seul type de fiche produit pour les deux catégories du site
// ('laptop' ou 'accessory'), géré uniquement depuis le back-office admin
// (App\Http\Controllers\Admin\AdminProductController).
// Le front-end (App\Http\Controllers\Client\HomeController) n'affiche
// jamais que les 6 derniers produits de chaque type.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['laptop', 'accessory']);
            $table->string('name');
            $table->text('specs'); // configuration / description technique
            $table->unsignedInteger('price'); // prix exprimé en points
            $table->unsignedInteger('stock')->default(0);
            $table->string('image')->nullable(); // chemin dans public/images
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
