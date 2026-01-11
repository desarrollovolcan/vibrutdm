<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Asociaciones</h5>
        <a href="/associations/create" class="btn btn-primary">Nueva asociación</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($associations as $association): ?>
                    <tr>
                        <td><?php echo e($association['name']); ?></td>
                        <td class="actions">
                            <a href="/associations/edit?id=<?php echo (int)$association['id']; ?>" class="btn btn-light btn-sm">Editar</a>
                            <form method="post" action="/associations/delete" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo (int)$association['id']; ?>">
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
