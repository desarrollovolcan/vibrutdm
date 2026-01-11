<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Torneos</h5>
        <a href="/tournaments/create" class="btn btn-primary">Nuevo torneo</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
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
                            <a href="/tournaments/edit?id=<?php echo (int)$tournament['id']; ?>" class="btn btn-light btn-sm">Editar</a>
                            <form method="post" action="/tournaments/delete" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo (int)$tournament['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
