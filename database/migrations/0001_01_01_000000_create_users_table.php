<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Table centrale : un utilisateur est soit "client" soit "admin".
// Le rôle décide s'il accède au back-office (voir App\Http\Middleware\IsAdmin).
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // 'client' = achète sur le site, 'admin' = gère le back-office
            $table->enum('role', ['client', 'admin'])->default('client');

            // Monnaie virtuelle du site (aucun paiement réel)
            $table->unsignedInteger('points')->default(0);

            // Empêche de gagner des points plusieurs fois sur le même lien
            $table->boolean('github_claimed')->default(false);
            $table->boolean('youtube_claimed')->default(false);

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
