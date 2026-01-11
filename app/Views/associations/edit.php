<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Editar asociación</h3>
    <?php if ($association): ?>
        <form method="post" action="/associations/update" class="form-grid">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" value="<?php echo (int)$association['id']; ?>">
            <label>Nombre
                <input type="text" name="name" value="<?php echo e($association['name']); ?>" required>
            </label>
            <button type="submit" class="btn primary">Guardar</button>
        </form>
    <?php else: ?>
        <p>Asociación no encontrada.</p>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
