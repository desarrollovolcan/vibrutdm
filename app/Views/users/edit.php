<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Editar usuario</h5>
    </div>
    <div class="card-body">
        <?php if ($user): ?>
        <form method="post" action="/users/update" class="row g-3">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" value="<?php echo (int)$user['id']; ?>">
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" value="<?php echo e($user['name']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo e($user['email']); ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Rol</label>
                <select name="role" class="form-select">
                    <?php foreach (['ADMIN', 'OPERADOR', 'LECTURA'] as $role): ?>
                        <option value="<?php echo $role; ?>" <?php echo $user['role'] === $role ? 'selected' : ''; ?>><?php echo $role; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Contraseña (opcional)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" <?php echo $user['is_active'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="is_active">Activo</label>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        <?php else: ?>
            <p class="mb-0">No se encontró el usuario.</p>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
