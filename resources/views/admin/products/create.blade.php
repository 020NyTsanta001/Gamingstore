@extends('layouts.admin')

@section('title', 'Nouveau produit — Admin')

@section('content')
<h2 class="fw-bold mb-4">Nouveau produit</h2>

<div class="admin-card p-4" style="max-width: 560px;">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.products._form')
    </form>
</div>
@endsection
