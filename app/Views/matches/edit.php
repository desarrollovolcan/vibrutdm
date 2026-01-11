<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Resultado del partido</h3>
    <?php if ($match): ?>
        <p><strong><?php echo e($match['player_a_name']); ?></strong> vs <strong><?php echo e($match['player_b_name']); ?></strong></p>
        <form method="post" action="/matches/update" class="form-grid" id="sets-form">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="match_id" value="<?php echo (int)$match['id']; ?>">
            <input type="hidden" name="redirect_to" value="<?php echo e($_GET['redirect_to'] ?? '/'); ?>">
            <div id="sets-wrapper">
                <?php $maxSets = (int)$match['best_of_sets']; ?>
                <?php for ($i = 1; $i <= $maxSets; $i++): ?>
                    <div class="set-row">
                        <span>Set <?php echo $i; ?></span>
                        <input type="number" name="sets[<?php echo $i; ?>][points_a]" min="0" value="<?php echo e($sets[$i-1]['points_a'] ?? ''); ?>" placeholder="A">
                        <input type="number" name="sets[<?php echo $i; ?>][points_b]" min="0" value="<?php echo e($sets[$i-1]['points_b'] ?? ''); ?>" placeholder="B">
                    </div>
                <?php endfor; ?>
            </div>
            <button type="submit" class="btn primary">Guardar resultado</button>
        </form>
    <?php else: ?>
        <p>Partido no encontrado.</p>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
