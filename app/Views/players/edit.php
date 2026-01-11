<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Editar jugador</h5>
    </div>
    <div class="card-body">
        <?php if ($player): ?>
            <form method="post" action="/players/update" class="row g-3">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo (int)$player['id']; ?>">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e($player['name']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Asociación</label>
                    <select name="association_id" class="form-select">
                        <option value="">Sin asociación</option>
                        <?php foreach ($associations as $association): ?>
                            <option value="<?php echo (int)$association['id']; ?>" <?php echo (int)$player['association_id'] === (int)$association['id'] ? 'selected' : ''; ?>><?php echo e($association['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Ranking seed</label>
                    <input type="number" name="ranking_seed" class="form-control" value="<?php echo e($player['ranking_seed']); ?>">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        <?php else: ?>
            <p class="mb-0">Jugador no encontrado.</p>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
