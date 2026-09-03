<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

// Page d'accueil du back-office : quelques chiffres clés pour l'admin.
class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::where('role', 'client')->count(),
            'laptops' => Product::where('type', 'laptop')->count(),
            'accessories' => Product::where('type', 'accessory')->count(),
            'orders' => Order::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
