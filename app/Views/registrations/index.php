<?php
ob_start();
?>
<div class="row">
    <div class="col-xl-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Inscribir jugador</h4>
            </div>
            <div class="card-body">
                <form method="post" action="<?= htmlspecialchars($baseUrl) ?>/registrations">
                    <input type="hidden" name="category_id" value="<?= htmlspecialchars((string) ($category['id'] ?? 0)) ?>">
                    <div class="mb-3">
                        <label class="form-label">Jugador</label>
                        <select class="form-control" name="player_id">
                            <?php foreach ($players as $player) : ?>
                                <option value="<?= htmlspecialchars((string) $player['id']) ?>">
                                    <?= htmlspecialchars($player['first_name'] . ' ' . $player['last_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ranking seed</label>
                        <input type="number" class="form-control" name="ranking_seed">
                    </div>
                    <button class="btn btn-primary" type="submit">Inscribir</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-7">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Inscritos</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Jugador</th>
                            <th>Seed</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registrations as $registration) : ?>
                            <tr>
                                <td><?= htmlspecialchars($registration['first_name'] . ' ' . $registration['last_name']) ?></td>
                                <td><?= htmlspecialchars((string) $registration['ranking_seed']) ?></td>
                                <td>
                                    <form method="post" action="<?= htmlspecialchars($baseUrl) ?>/registrations/delete">
                                        <input type="hidden" name="category_id" value="<?= htmlspecialchars((string) $registration['category_id']) ?>">
                                        <input type="hidden" name="player_id" value="<?= htmlspecialchars((string) $registration['player_id']) ?>">
                                        <button class="btn btn-sm btn-danger" type="submit">Quitar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($registrations)) : ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">No hay inscritos aún.</td>
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
$title = 'Inscripciones';
require __DIR__ . '/../layouts/main.php';
?>
