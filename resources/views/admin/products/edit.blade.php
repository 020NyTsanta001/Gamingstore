@extends('layouts.admin')

@section('title', 'Modifier le produit — Admin')

@section('content')
<h2 class="fw-bold mb-4">Modifier {{ $product->name }}</h2>

<div class="admin-card p-4" style="max-width: 560px;">
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('admin.products._form')
    </form>
</div>
@endsection
