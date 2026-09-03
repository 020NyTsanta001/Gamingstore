<div class="mb-3">
    <label class="form-label">Nom</label>
    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">E-mail</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Mot de passe {{ isset($user) ? '(laisser vide pour ne pas changer)' : '' }}</label>
    <input type="password" name="password" class="form-control" {{ isset($user) ? '' : 'required' }}>
</div>
<div class="mb-3">
    <label class="form-label">Rôle</label>
    <select name="role" class="form-select" required>
        <option value="client" {{ old('role', $user->role ?? 'client') == 'client' ? 'selected' : '' }}>Client</option>
        <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
</div>
<div class="mb-3">
    <label class="form-label">Points</label>
    <input type="number" name="points" min="0" class="form-control" value="{{ old('points', $user->points ?? 0) }}">
</div>
<button class="btn btn-neon">Enregistrer</button>
