<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h3>Usuarios</h3>
        <a href="/users/create" class="btn primary">Nuevo usuario</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo e($user['name']); ?></td>
                <td><?php echo e($user['email']); ?></td>
                <td><?php echo e($user['role']); ?></td>
                <td><?php echo $user['is_active'] ? 'Sí' : 'No'; ?></td>
                <td class="actions">
                    <a href="/users/edit?id=<?php echo (int)$user['id']; ?>" class="btn">Editar</a>
                    <form method="post" action="/users/delete" class="inline">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo (int)$user['id']; ?>">
                        <button type="submit" class="btn danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
