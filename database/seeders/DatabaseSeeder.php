<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Compte admin (accès back-office)
        User::create([
            'name' => 'Admin',
            'email' => 'nytsantaf@gmail.com',
            'password' => Hash::make('nyTsanta001'),
            'role' => 'admin',
        ]);

        // Compte client de test avec quelques points de départ
        User::create([
            'name' => 'Client Test',
            'email' => 'client@gamingstore.test',
            'password' => Hash::make('password'),
            'role' => 'client',
            'points' => 500,
        ]);

        $laptops = [
            ['name' => 'Predator Helios 16', 'price' => 2200, 'specs' => "RTX 4070 · Intel i7-14700HX\n16 Go RAM · 1 To SSD · Écran 16\" 240Hz"],
            ['name' => 'ROG Strix G16', 'price' => 1950, 'specs' => "RTX 4060 · Intel i7-13650HX\n16 Go RAM · 512 Go SSD · Écran 16\" 165Hz"],
            ['name' => 'Legion Pro 5', 'price' => 1800, 'specs' => "RTX 4060 · AMD Ryzen 7 7745HX\n16 Go RAM · 1 To SSD · Écran 16\" 165Hz"],
            ['name' => 'Alienware m16', 'price' => 2600, 'specs' => "RTX 4080 · Intel i9-13900HX\n32 Go RAM · 1 To SSD · Écran 16\" 240Hz"],
            ['name' => 'MSI Katana 15', 'price' => 1400, 'specs' => "RTX 4050 · Intel i5-13420H\n16 Go RAM · 512 Go SSD · Écran 15.6\" 144Hz"],
            ['name' => 'HP Omen 17', 'price' => 2000, 'specs' => "RTX 4070 · Intel i7-13700HX\n32 Go RAM · 1 To SSD · Écran 17.3\" 165Hz"],
        ];

        foreach ($laptops as $l) {
            Product::create([
                'type' => 'laptop',
                'name' => $l['name'],
                'specs' => $l['specs'],
                'price' => $l['price'],
                'stock' => 5,
            ]);
        }

        $accessories = [
            ['name' => 'Souris gaming RGB', 'price' => 60, 'specs' => "Capteur optique 16000 DPI\n6 boutons programmables · rétroéclairage RGB"],
            ['name' => 'Clavier mécanique', 'price' => 120, 'specs' => "Switches rouges · rétroéclairage RGB\nFormat TKL, câble tressé"],
            ['name' => 'Casque gaming 7.1', 'price' => 90, 'specs' => "Son surround virtuel 7.1\nMicro amovible, coussinets mémoire de forme"],
            ['name' => 'Tapis de souris XXL', 'price' => 30, 'specs' => "900x400mm · surface tissu\nBase antidérapante"],
            ['name' => 'Support ordinateur', 'price' => 45, 'specs' => "Aluminium, hauteur réglable\nAmélioration ventilation"],
            ['name' => 'Webcam 1080p', 'price' => 55, 'specs' => "Full HD 1080p 60fps\nMicro intégré, autofocus"],
        ];

        foreach ($accessories as $a) {
            Product::create([
                'type' => 'accessory',
                'name' => $a['name'],
                'specs' => $a['specs'],
                'price' => $a['price'],
                'stock' => 8,
            ]);
        }
    }
}
