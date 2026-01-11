<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Grupos</h5>
    </div>
    <div class="card-body">
        <form method="get" action="/groups" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Categoría</label>
                <select name="category_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Seleccione</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo (int)$category['id']; ?>" <?php echo (int)$categoryId === (int)$category['id'] ? 'selected' : ''; ?>><?php echo e($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <?php if ($categoryId): ?>
            <form method="post" action="/groups/generate" class="row g-3 align-items-center mt-2">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="category_id" value="<?php echo (int)$categoryId; ?>">
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="avoid_same_association" id="avoid_same_association" class="form-check-input">
                        <label class="form-check-label" for="avoid_same_association">Minimizar repetidos por asociación</label>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Generar grupos</button>
                </div>
            </form>

            <div class="table-responsive mt-3">
                <table class="table table-striped table-hover">
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
                            <td><a href="/groups/show?id=<?php echo (int)$group['id']; ?>&category_id=<?php echo (int)$categoryId; ?>" class="btn btn-light btn-sm">Ver detalle</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
