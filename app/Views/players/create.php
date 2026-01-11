<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Nuevo jugador</h3>
    <form method="post" action="/players/store" class="form-grid">
        <?php echo csrf_field(); ?>
        <label>Nombre
            <input type="text" name="name" required>
        </label>
        <label>Asociación
            <select name="association_id">
                <option value="">Sin asociación</option>
                <?php foreach ($associations as $association): ?>
                    <option value="<?php echo (int)$association['id']; ?>"><?php echo e($association['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Ranking seed
            <input type="number" name="ranking_seed">
        </label>
        <button type="submit" class="btn primary">Guardar</button>
    </form>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
