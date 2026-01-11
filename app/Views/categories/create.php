<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Nueva categoría</h5>
    </div>
    <div class="card-body">
        <form method="post" action="/categories/store" class="row g-3">
            <?php echo csrf_field(); ?>
            <div class="col-md-6">
                <label class="form-label">Torneo</label>
                <select name="tournament_id" class="form-select" required>
                    <?php foreach ($tournaments as $tournament): ?>
                        <option value="<?php echo (int)$tournament['id']; ?>"><?php echo e($tournament['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Formato grupos</label>
                <input type="number" name="group_size" class="form-control" value="3" min="2" max="10">
            </div>
            <div class="col-md-4">
                <label class="form-label">Clasifican por grupo</label>
                <input type="number" name="qualify_per_group" class="form-control" value="2" min="1" max="4">
            </div>
            <div class="col-md-4">
                <label class="form-label">Best of sets</label>
                <input type="number" name="best_of_sets" class="form-control" value="5" min="1" max="7">
            </div>
            <div class="col-md-4">
                <label class="form-label">Puntos por set</label>
                <input type="number" name="points_per_set" class="form-control" value="11" min="5" max="21">
            </div>
            <div class="col-md-4">
                <label class="form-label">Tamaño de llave</label>
                <select name="bracket_size" class="form-select">
                    <?php foreach ([2,4,8,16,32,64,128] as $size): ?>
                        <option value="<?php echo $size; ?>"><?php echo $size; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Criterio desempate</label>
                <input type="text" name="tiebreak_criteria" class="form-control" value="matches_won,sets_ratio,points_ratio,head_to_head">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
