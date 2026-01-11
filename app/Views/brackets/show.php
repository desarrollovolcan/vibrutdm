<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Llave eliminatoria</h3>
    <?php if ($category): ?>
        <form method="post" action="/brackets/generate" class="form-inline">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="category_id" value="<?php echo (int)$category['id']; ?>">
            <button type="submit" class="btn primary">Generar llave</button>
        </form>
    <?php endif; ?>

    <?php if ($bracket): ?>
        <div class="bracket-wrapper">
            <?php foreach ($matchesByRound as $round => $matches): ?>
                <div class="bracket-round">
                    <h4>Ronda <?php echo e($round); ?></h4>
                    <?php foreach ($matches as $match): ?>
                        <div class="bracket-match">
                            <div class="team <?php echo (int)$match['winner_id'] === (int)$match['player_a_id'] ? 'winner' : ''; ?>">
                                <span><?php echo e($match['player_a_name'] ?? 'BYE'); ?></span>
                            </div>
                            <div class="team <?php echo (int)$match['winner_id'] === (int)$match['player_b_id'] ? 'winner' : ''; ?>">
                                <span><?php echo e($match['player_b_name'] ?? 'BYE'); ?></span>
                            </div>
                            <a href="/matches/edit?id=<?php echo (int)$match['id']; ?>&redirect_to=<?php echo urlencode('/brackets/show?category_id=' . (int)$category['id']); ?>" class="btn tiny">Resultado</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No hay llave generada.</p>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
