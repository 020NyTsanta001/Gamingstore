@extends('layouts.admin')

@section('title', 'Nouveau compte — Admin')

@section('content')
<h2 class="fw-bold mb-4">Nouveau compte</h2>

<div class="admin-card p-4" style="max-width: 500px;">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        @include('admin.users._form')
    </form>
</div>
@endsection
