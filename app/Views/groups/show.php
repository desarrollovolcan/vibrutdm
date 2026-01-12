<?php
ob_start();
?>
<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Jugadores del grupo</h4>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($players as $player) : ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <?= htmlspecialchars($player['first_name'] . ' ' . $player['last_name']) ?>
                            <span class="badge bg-primary">#<?= htmlspecialchars((string) $player['position']) ?></span>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($players)) : ?>
                        <li class="list-group-item text-muted">Sin jugadores aún.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Partidos</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Jugador A</th>
                            <th>Jugador B</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($matches as $match) : ?>
                            <tr>
                                <td><?= htmlspecialchars((string) $match['player_a_id']) ?></td>
                                <td><?= htmlspecialchars((string) $match['player_b_id']) ?></td>
                                <td><?= htmlspecialchars($match['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($matches)) : ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">Sin partidos aún.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <form method="post" action="/groups/recalculate">
                    <input type="hidden" name="group_id" value="<?= htmlspecialchars((string) $groupId) ?>">
                    <button class="btn btn-outline-primary" type="submit">Recalcular standings</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Detalle de grupo';
require __DIR__ . '/../layouts/main.php';
?>
