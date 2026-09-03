<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Une "commande" = un panier validé par un client (simulation, sans paiement réel).
// Créée uniquement par App\Http\Controllers\Client\CartController@checkout
// et consultée en lecture seule par App\Http\Controllers\Admin\AdminOrderController.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('total_points'); // total payé en points
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
