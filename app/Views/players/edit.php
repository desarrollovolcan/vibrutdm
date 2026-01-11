<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Editar jugador</h3>
    <?php if ($player): ?>
        <form method="post" action="/players/update" class="form-grid">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" value="<?php echo (int)$player['id']; ?>">
            <label>Nombre
                <input type="text" name="name" value="<?php echo e($player['name']); ?>" required>
            </label>
            <label>Asociación
                <select name="association_id">
                    <option value="">Sin asociación</option>
                    <?php foreach ($associations as $association): ?>
                        <option value="<?php echo (int)$association['id']; ?>" <?php echo (int)$player['association_id'] === (int)$association['id'] ? 'selected' : ''; ?>><?php echo e($association['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Ranking seed
                <input type="number" name="ranking_seed" value="<?php echo e($player['ranking_seed']); ?>">
            </label>
            <button type="submit" class="btn primary">Guardar</button>
        </form>
    <?php else: ?>
        <p>Jugador no encontrado.</p>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
