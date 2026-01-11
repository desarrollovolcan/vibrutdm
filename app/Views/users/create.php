<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Nuevo usuario</h3>
    <form method="post" action="/users/store" class="form-grid">
        <?php echo csrf_field(); ?>
        <label>Nombre
            <input type="text" name="name" required>
        </label>
        <label>Email
            <input type="email" name="email" required>
        </label>
        <label>Rol
            <select name="role">
                <option value="ADMIN">ADMIN</option>
                <option value="OPERADOR">OPERADOR</option>
                <option value="LECTURA">LECTURA</option>
            </select>
        </label>
        <label>Contraseña
            <input type="password" name="password" required>
        </label>
        <label class="checkbox">
            <input type="checkbox" name="is_active" checked> Activo
        </label>
        <button type="submit" class="btn primary">Guardar</button>
    </form>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
