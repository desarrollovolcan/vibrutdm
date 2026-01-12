<?php
ob_start();
?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Partidos del grupo</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Jugador A</th>
                            <th>Jugador B</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($matches as $match) : ?>
                            <tr>
                                <td><?= htmlspecialchars((string) $match['id']) ?></td>
                                <td><?= htmlspecialchars((string) $match['player_a_id']) ?></td>
                                <td><?= htmlspecialchars((string) $match['player_b_id']) ?></td>
                                <td><?= htmlspecialchars($match['status']) ?></td>
                                <td><a class="btn btn-sm btn-primary" href="/results/edit?match_id=<?= htmlspecialchars((string) $match['id']) ?>">Cargar sets</a></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($matches)) : ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">No hay partidos.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Partidos';
require __DIR__ . '/../layouts/main.php';
?>
