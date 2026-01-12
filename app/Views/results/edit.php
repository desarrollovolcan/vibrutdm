<?php
ob_start();
?>
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Resultados por sets</h4>
            </div>
            <div class="card-body">
                <?php if (!$match) : ?>
                    <p class="text-muted">Match no encontrado.</p>
                <?php else : ?>
                    <form method="post" action="/results/update">
                        <input type="hidden" name="match_id" value="<?= htmlspecialchars((string) $match['id']) ?>">
                        <?php for ($i = 1; $i <= (int) $match['best_of_sets']; $i++) : ?>
                            <div class="row mb-3">
                                <div class="col-md-2">Set <?= $i ?></div>
                                <div class="col-md-5">
                                    <input type="number" class="form-control" name="sets[<?= $i ?>][points_a]" value="<?= htmlspecialchars((string) ($sets[$i - 1]['points_a'] ?? '')) ?>">
                                </div>
                                <div class="col-md-5">
                                    <input type="number" class="form-control" name="sets[<?= $i ?>][points_b]" value="<?= htmlspecialchars((string) ($sets[$i - 1]['points_b'] ?? '')) ?>">
                                </div>
                            </div>
                        <?php endfor; ?>
                        <button class="btn btn-primary" type="submit">Guardar resultados</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Resultados';
require __DIR__ . '/../layouts/main.php';
?>
