<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Editar asociación</h5>
    </div>
    <div class="card-body">
        <?php if ($association): ?>
            <form method="post" action="/associations/update" class="row g-3">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo (int)$association['id']; ?>">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e($association['name']); ?>" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        <?php else: ?>
            <p class="mb-0">Asociación no encontrada.</p>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
