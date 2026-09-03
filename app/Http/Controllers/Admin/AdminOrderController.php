<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

// Vue "qui a acheté quoi" demandée dans le cahier des charges.
// Lecture seule : les commandes sont créées uniquement par
// App\Http\Controllers\Client\CartController@checkout.
class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items'])->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }
}
