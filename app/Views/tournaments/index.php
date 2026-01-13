<?php
ob_start();
?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Torneos</h4>
                <a href="<?= htmlspecialchars($baseUrl) ?>/tournaments/create" class="btn btn-primary">Nuevo torneo</a>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Ubicación</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tournaments as $tournament) : ?>
                            <tr>
                                <td><?= htmlspecialchars($tournament['name']) ?></td>
                                <td><?= htmlspecialchars($tournament['location']) ?></td>
                                <td><?= htmlspecialchars($tournament['start_date']) ?></td>
                                <td><?= htmlspecialchars($tournament['end_date']) ?></td>
                                <td><?= htmlspecialchars($tournament['status']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($tournaments)) : ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Sin torneos aún.</td>
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
$title = 'Torneos';
require __DIR__ . '/../layouts/main.php';
?>
