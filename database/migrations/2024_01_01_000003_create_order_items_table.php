<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Détail ligne par ligne d'une commande (un produit peut être acheté
// plusieurs fois par des clients différents, donc pas de relation directe
// user <-> product : on passe toujours par order_items).
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('product_name'); // copie du nom au moment de l'achat
            $table->unsignedInteger('unit_price'); // copie du prix au moment de l'achat
            $table->unsignedInteger('quantity')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
