<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Grupos</h3>
    <form method="get" action="/groups" class="form-inline">
        <label>Categoría
            <select name="category_id" onchange="this.form.submit()">
                <option value="">Seleccione</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo (int)$category['id']; ?>" <?php echo (int)$categoryId === (int)$category['id'] ? 'selected' : ''; ?>><?php echo e($category['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </form>

    <?php if ($categoryId): ?>
        <form method="post" action="/groups/generate" class="form-inline">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="category_id" value="<?php echo (int)$categoryId; ?>">
            <label class="checkbox">
                <input type="checkbox" name="avoid_same_association"> Minimizar repetidos por asociación
            </label>
            <button type="submit" class="btn primary">Generar grupos</button>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Grupo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($groups as $group): ?>
                <tr>
                    <td>Grupo <?php echo e($group['number']); ?></td>
                    <td><a href="/groups/show?id=<?php echo (int)$group['id']; ?>&category_id=<?php echo (int)$categoryId; ?>" class="btn">Ver detalle</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
