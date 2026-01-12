<?php
ob_start();
?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Llave eliminatoria</h4>
            </div>
            <div class="card-body">
                <?php if (!$bracket) : ?>
                    <p class="text-muted">No se ha generado una llave para esta categoría.</p>
                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Ronda</th>
                                    <th>Match</th>
                                    <th>Jugador A</th>
                                    <th>Jugador B</th>
                                    <th>Ganador</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($matches as $match) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars((string) $match['round_number']) ?></td>
                                        <td><?= htmlspecialchars((string) $match['match_index']) ?></td>
                                        <td><?= htmlspecialchars((string) $match['player_a_id']) ?></td>
                                        <td><?= htmlspecialchars((string) $match['player_b_id']) ?></td>
                                        <td><?= htmlspecialchars((string) $match['winner_id']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($matches)) : ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No hay partidos creados.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Llaves';
require __DIR__ . '/../layouts/main.php';
?>
