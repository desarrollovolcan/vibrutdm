<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Nueva categoría</h3>
    <form method="post" action="/categories/store" class="form-grid">
        <?php echo csrf_field(); ?>
        <label>Torneo
            <select name="tournament_id" required>
                <?php foreach ($tournaments as $tournament): ?>
                    <option value="<?php echo (int)$tournament['id']; ?>"><?php echo e($tournament['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Nombre
            <input type="text" name="name" required>
        </label>
        <label>Formato grupos
            <input type="number" name="group_size" value="3" min="2" max="10">
        </label>
        <label>Clasifican por grupo
            <input type="number" name="qualify_per_group" value="2" min="1" max="4">
        </label>
        <label>Best of sets
            <input type="number" name="best_of_sets" value="5" min="1" max="7">
        </label>
        <label>Puntos por set
            <input type="number" name="points_per_set" value="11" min="5" max="21">
        </label>
        <label>Tamaño de llave
            <select name="bracket_size">
                <?php foreach ([2,4,8,16,32,64,128] as $size): ?>
                    <option value="<?php echo $size; ?>"><?php echo $size; ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Criterio desempate
            <input type="text" name="tiebreak_criteria" value="matches_won,sets_ratio,points_ratio,head_to_head">
        </label>
        <button type="submit" class="btn primary">Guardar</button>
    </form>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
