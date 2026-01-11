<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Editar usuario</h3>
    <?php if ($user): ?>
    <form method="post" action="/users/update" class="form-grid">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo (int)$user['id']; ?>">
        <label>Nombre
            <input type="text" name="name" value="<?php echo e($user['name']); ?>" required>
        </label>
        <label>Email
            <input type="email" name="email" value="<?php echo e($user['email']); ?>" required>
        </label>
        <label>Rol
            <select name="role">
                <?php foreach (['ADMIN', 'OPERADOR', 'LECTURA'] as $role): ?>
                    <option value="<?php echo $role; ?>" <?php echo $user['role'] === $role ? 'selected' : ''; ?>><?php echo $role; ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Contraseña (opcional)
            <input type="password" name="password">
        </label>
        <label class="checkbox">
            <input type="checkbox" name="is_active" <?php echo $user['is_active'] ? 'checked' : ''; ?>> Activo
        </label>
        <button type="submit" class="btn primary">Guardar</button>
    </form>
    <?php else: ?>
        <p>No se encontró el usuario.</p>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
