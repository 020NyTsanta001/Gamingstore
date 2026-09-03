@extends('layouts.admin')

@section('title', 'Modifier le compte — Admin')

@section('content')
<h2 class="fw-bold mb-4">Modifier {{ $user->name }}</h2>

<div class="admin-card p-4" style="max-width: 500px;">
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf @method('PUT')
        @include('admin.users._form')
    </form>
</div>
@endsection
