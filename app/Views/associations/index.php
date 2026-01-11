<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h3>Asociaciones</h3>
        <a href="/associations/create" class="btn primary">Nueva asociación</a>
    </div>
    <table class="table">
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
                    <a href="/associations/edit?id=<?php echo (int)$association['id']; ?>" class="btn">Editar</a>
                    <form method="post" action="/associations/delete" class="inline">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo (int)$association['id']; ?>">
                        <button type="submit" class="btn danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
