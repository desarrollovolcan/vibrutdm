<?php
ob_start();
?>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Categorías</h4>
                <a href="/categories/create?tournament_id=<?= htmlspecialchars((string) $tournamentId) ?>" class="btn btn-primary">Nueva categoría</a>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Jugadores por grupo</th>
                            <th>Clasifican</th>
                            <th>Best of</th>
                            <th>Tamaño llave</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) : ?>
                            <tr>
                                <td><?= htmlspecialchars($category['name']) ?></td>
                                <td><?= htmlspecialchars($category['players_per_group']) ?></td>
                                <td><?= htmlspecialchars($category['qualify_per_group']) ?></td>
                                <td><?= htmlspecialchars($category['best_of_sets']) ?></td>
                                <td><?= htmlspecialchars($category['bracket_size']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($categories)) : ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Selecciona un torneo para ver categorías.</td>
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
$title = 'Categorías';
require __DIR__ . '/../layouts/main.php';
?>
