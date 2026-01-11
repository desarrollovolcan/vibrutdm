<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Llave eliminatoria</h5>
    </div>
    <div class="card-body">
        <?php if ($category): ?>
            <form method="post" action="/brackets/generate" class="row g-3 align-items-center mb-3">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="category_id" value="<?php echo (int)$category['id']; ?>">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Generar llave</button>
                </div>
            </form>
        <?php endif; ?>

        <?php if ($bracket): ?>
            <div class="bracket-wrapper">
                <?php foreach ($matchesByRound as $round => $matches): ?>
                    <div class="bracket-round">
                        <h6>Ronda <?php echo e($round); ?></h6>
                        <?php foreach ($matches as $match): ?>
                            <div class="bracket-match">
                                <div class="team <?php echo (int)$match['winner_id'] === (int)$match['player_a_id'] ? 'winner' : ''; ?>">
                                    <span><?php echo e($match['player_a_name'] ?? 'BYE'); ?></span>
                                </div>
                                <div class="team <?php echo (int)$match['winner_id'] === (int)$match['player_b_id'] ? 'winner' : ''; ?>">
                                    <span><?php echo e($match['player_b_name'] ?? 'BYE'); ?></span>
                                </div>
                                <a href="/matches/edit?id=<?php echo (int)$match['id']; ?>&redirect_to=<?php echo urlencode('/brackets/show?category_id=' . (int)$category['id']); ?>" class="btn btn-light btn-sm">Resultado</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="mb-0">No hay llave generada.</p>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
