<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Seleccionar categoría</h3>
    <form method="get" action="/brackets" class="form-inline">
        <label>Categoría
            <select name="category_id" onchange="this.form.submit()">
                <option value="">Seleccione</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo (int)$category['id']; ?>"><?php echo e($category['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </form>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
