@extends('layouts.admin')

@section('title', 'Achats clients — Admin')

@section('content')
<h2 class="fw-bold mb-4">Qui a acheté quoi</h2>

<div class="admin-card p-3">
    <table class="table align-middle mb-0">
        <thead>
            <tr class="text-muted">
                <th>Client</th>
                <th>Produits achetés</th>
                <th>Total</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>{{ $order->user->name }} <br><span class="text-muted small">{{ $order->user->email }}</span></td>
                    <td>
                        @foreach ($order->items as $item)
                            <div class="small">{{ $item->quantity }} × {{ $item->product_name }} ({{ $item->unit_price }} pts)</div>
                        @endforeach
                    </td>
                    <td>{{ $order->total_points }} pts</td>
                    <td class="small text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-muted">Aucun achat pour le moment.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $orders->links() }}</div>
@endsection
