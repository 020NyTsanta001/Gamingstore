@extends('layouts.admin')

@section('title', 'Comptes utilisateurs — Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Comptes utilisateurs</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-neon">+ Nouveau compte</a>
</div>

<div class="admin-card p-3">
    <table class="table align-middle mb-0">
        <thead>
            <tr class="text-muted">
                <th>Nom</th>
                <th>E-mail</th>
                <th>Rôle</th>
                <th>Points</th>
                <th class="text-end">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge {{ $user->isAdmin() ? 'bg-dark' : 'bg-secondary' }}">{{ $user->role }}</span></td>
                    <td>{{ $user->points }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary">Modifier</a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce compte ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-3">{{ $users->links() }}</div>
@endsection
