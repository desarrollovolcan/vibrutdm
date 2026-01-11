<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Resultado del partido</h5>
    </div>
    <div class="card-body">
        <?php if ($match): ?>
            <p class="mb-4"><strong><?php echo e($match['player_a_name']); ?></strong> vs <strong><?php echo e($match['player_b_name']); ?></strong></p>
            <form method="post" action="/matches/update" class="row g-3" id="sets-form">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="match_id" value="<?php echo (int)$match['id']; ?>">
                <input type="hidden" name="redirect_to" value="<?php echo e($_GET['redirect_to'] ?? '/'); ?>">
                <div id="sets-wrapper" class="col-12">
                    <?php $maxSets = (int)$match['best_of_sets']; ?>
                    <?php for ($i = 1; $i <= $maxSets; $i++): ?>
                        <div class="row g-2 align-items-center mb-2">
                            <div class="col-auto">
                                <span class="fw-semibold">Set <?php echo $i; ?></span>
                            </div>
                            <div class="col">
                                <input type="number" name="sets[<?php echo $i; ?>][points_a]" min="0" class="form-control" value="<?php echo e($sets[$i-1]['points_a'] ?? ''); ?>" placeholder="A">
                            </div>
                            <div class="col">
                                <input type="number" name="sets[<?php echo $i; ?>][points_b]" min="0" class="form-control" value="<?php echo e($sets[$i-1]['points_b'] ?? ''); ?>" placeholder="B">
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Guardar resultado</button>
                </div>
            </form>
        <?php else: ?>
            <p class="mb-0">Partido no encontrado.</p>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
