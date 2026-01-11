<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h3>Torneos</h3>
        <a href="/tournaments/create" class="btn primary">Nuevo torneo</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Sede</th>
                <th>Inicio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tournaments as $tournament): ?>
            <tr>
                <td><?php echo e($tournament['name']); ?></td>
                <td><?php echo e($tournament['venue']); ?></td>
                <td><?php echo e($tournament['date_start']); ?></td>
                <td><?php echo e($tournament['status']); ?></td>
                <td class="actions">
                    <a href="/tournaments/edit?id=<?php echo (int)$tournament['id']; ?>" class="btn">Editar</a>
                    <form method="post" action="/tournaments/delete" class="inline">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo (int)$tournament['id']; ?>">
                        <button type="submit" class="btn danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
