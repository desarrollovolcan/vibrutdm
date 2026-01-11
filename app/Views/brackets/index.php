<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Seleccionar categoría</h5>
    </div>
    <div class="card-body">
        <form method="get" action="/brackets" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Categoría</label>
                <select name="category_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Seleccione</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo (int)$category['id']; ?>"><?php echo e($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
