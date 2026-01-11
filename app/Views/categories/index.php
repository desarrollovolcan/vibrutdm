<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h3>Categorías</h3>
        <a href="/categories/create" class="btn primary">Nueva categoría</a>
    </div>
    <table class="table">
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
                    <a href="/categories/edit?id=<?php echo (int)$category['id']; ?>" class="btn">Editar</a>
                    <form method="post" action="/categories/delete" class="inline">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo (int)$category['id']; ?>">
                        <button type="submit" class="btn danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
