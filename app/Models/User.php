<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'points',
        'github_claimed', 'youtube_claimed',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'github_claimed' => 'boolean',
            'youtube_claimed' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Historique des achats de ce client (utilisé par AdminOrderController
    // et par le profil client pour afficher "mes achats").
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
