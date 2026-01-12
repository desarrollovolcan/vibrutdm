<?php
ob_start();
?>
<div class="row">
    <div class="col-xl-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Registrar jugador</h4>
            </div>
            <div class="card-body">
                <form method="post" action="/players">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Apellido</label>
                        <input type="text" class="form-control" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Asociación</label>
                        <select class="form-control" name="association_id">
                            <option value="">Seleccione</option>
                            <?php foreach ($associations as $association) : ?>
                                <option value="<?= htmlspecialchars((string) $association['id']) ?>">
                                    <?= htmlspecialchars($association['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ranking puntos</label>
                        <input type="number" class="form-control" name="ranking_points" value="0">
                    </div>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-7">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Listado de jugadores</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Asociación</th>
                            <th>Ranking</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($players as $player) : ?>
                            <tr>
                                <td><?= htmlspecialchars($player['first_name'] . ' ' . $player['last_name']) ?></td>
                                <td><?= htmlspecialchars((string) $player['association_id']) ?></td>
                                <td><?= htmlspecialchars((string) $player['ranking_points']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($players)) : ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">No hay jugadores registrados.</td>
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
$title = 'Jugadores';
require __DIR__ . '/../layouts/main.php';
?>
