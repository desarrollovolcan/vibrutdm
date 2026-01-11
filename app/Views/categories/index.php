<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Categorías</h5>
        <a href="/categories/create" class="btn btn-primary">Nueva categoría</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Torneo</th>
                        <th>Grupos</th>
                        <th>Clasifican</th>
                        <th>Llave</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?php echo e($category['name']); ?></td>
                        <td><?php echo e($category['tournament_name']); ?></td>
                        <td><?php echo e($category['group_size']); ?></td>
                        <td><?php echo e($category['qualify_per_group']); ?></td>
                        <td><?php echo e($category['bracket_size']); ?></td>
                        <td class="actions">
                            <a href="/categories/edit?id=<?php echo (int)$category['id']; ?>" class="btn btn-light btn-sm">Editar</a>
                            <form method="post" action="/categories/delete" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" value="<?php echo (int)$category['id']; ?>">
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
