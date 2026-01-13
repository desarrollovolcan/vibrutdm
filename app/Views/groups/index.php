<?php
ob_start();
?>
<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Generar grupos</h4>
            </div>
            <div class="card-body">
                <form method="post" action="<?= htmlspecialchars($baseUrl) ?>/groups/generate">
                    <input type="hidden" name="category_id" value="<?= htmlspecialchars((string) $categoryId) ?>">
                    <div class="mb-3">
                        <label class="form-label">Modo de reparto</label>
                        <select class="form-control" name="modo">
                            <option value="snake">Snake</option>
                            <option value="snake_avoid_association">Snake evitando asociación</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Best of sets</label>
                        <input type="number" class="form-control" name="best_of_sets" value="5" min="1">
                    </div>
                    <button class="btn btn-primary" type="submit">Generar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Grupos</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Grupo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($groups as $group) : ?>
                            <tr>
                                <td>Grupo <?= htmlspecialchars((string) $group['group_number']) ?></td>
                                <td>
                                    <a href="<?= htmlspecialchars($baseUrl) ?>/groups/show?group_id=<?= htmlspecialchars((string) $group['id']) ?>" class="btn btn-sm btn-info">Ver</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($groups)) : ?>
                            <tr>
                                <td colspan="2" class="text-center text-muted">No hay grupos creados.</td>
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
$title = 'Grupos';
require __DIR__ . '/../layouts/main.php';
?>
