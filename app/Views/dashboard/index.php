<?php
ob_start();
?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Torneos activos</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Ubicación</th>
                                <th>Fechas</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tournaments as $tournament) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($tournament['name']) ?></td>
                                    <td><?= htmlspecialchars($tournament['location']) ?></td>
                                    <td><?= htmlspecialchars($tournament['start_date']) ?> - <?= htmlspecialchars($tournament['end_date']) ?></td>
                                    <td><?= htmlspecialchars($tournament['status']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($tournaments)) : ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No hay torneos registrados.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Dashboard';
require __DIR__ . '/../layouts/main.php';
?>
