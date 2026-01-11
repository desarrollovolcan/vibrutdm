<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Editar categoría</h3>
    <?php if ($category): ?>
    <form method="post" action="/categories/update" class="form-grid">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo (int)$category['id']; ?>">
        <label>Torneo
            <select name="tournament_id" required>
                <?php foreach ($tournaments as $tournament): ?>
                    <option value="<?php echo (int)$tournament['id']; ?>" <?php echo (int)$category['tournament_id'] === (int)$tournament['id'] ? 'selected' : ''; ?>><?php echo e($tournament['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Nombre
            <input type="text" name="name" value="<?php echo e($category['name']); ?>" required>
        </label>
        <label>Formato grupos
            <input type="number" name="group_size" value="<?php echo e($category['group_size']); ?>" min="2" max="10">
        </label>
        <label>Clasifican por grupo
            <input type="number" name="qualify_per_group" value="<?php echo e($category['qualify_per_group']); ?>" min="1" max="4">
        </label>
        <label>Best of sets
            <input type="number" name="best_of_sets" value="<?php echo e($category['best_of_sets']); ?>" min="1" max="7">
        </label>
        <label>Puntos por set
            <input type="number" name="points_per_set" value="<?php echo e($category['points_per_set']); ?>" min="5" max="21">
        </label>
        <label>Tamaño de llave
            <select name="bracket_size">
                <?php foreach ([2,4,8,16,32,64,128] as $size): ?>
                    <option value="<?php echo $size; ?>" <?php echo (int)$category['bracket_size'] === $size ? 'selected' : ''; ?>><?php echo $size; ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Criterio desempate
            <input type="text" name="tiebreak_criteria" value="<?php echo e($category['tiebreak_criteria']); ?>">
        </label>
        <button type="submit" class="btn primary">Guardar</button>
    </form>
    <?php else: ?>
        <p>Categoría no encontrada.</p>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
