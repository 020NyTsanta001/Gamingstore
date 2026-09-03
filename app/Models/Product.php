<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['type', 'name', 'specs', 'price', 'stock', 'image'];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'stock' => 'integer',
        ];
    }

    public function isOutOfStock(): bool
    {
        return $this->stock <= 0;
    }

    // Les 6 derniers ordinateurs portables ajoutés par l'admin (règle métier :
    // le site client n'affiche jamais plus de 6 fiches par catégorie).
    public static function laptopsForClient()
    {
        return static::where('type', 'laptop')->latest()->take(6)->get();
    }

    public static function accessoriesForClient()
    {
        return static::where('type', 'accessory')->latest()->take(6)->get();
    }
}
