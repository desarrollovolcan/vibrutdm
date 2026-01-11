<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Inscripciones</h5>
    </div>
    <div class="card-body">
        <form method="get" action="/registrations" class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Categoría</label>
                <select name="category_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Seleccione</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo (int)$category['id']; ?>" <?php echo (int)$categoryId === (int)$category['id'] ? 'selected' : ''; ?>><?php echo e($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <?php if ($categoryId): ?>
            <div class="row g-3 mt-2">
                <div class="col-xl-6">
                    <div class="border rounded p-3 h-100">
                        <h6 class="mb-3">Agregar jugador</h6>
                        <form method="post" action="/registrations/store" class="row g-3">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="category_id" value="<?php echo (int)$categoryId; ?>">
                            <div class="col-12">
                                <label class="form-label">Jugador</label>
                                <select name="player_id" class="form-select" required>
                                    <?php foreach ($players as $player): ?>
                                        <option value="<?php echo (int)$player['id']; ?>"><?php echo e($player['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Seed</label>
                                <input type="number" name="ranking_seed" class="form-control">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="border rounded p-3 h-100">
                        <h6 class="mb-3">Importar CSV</h6>
                        <form method="post" action="/registrations/import" enctype="multipart/form-data" class="row g-3">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="category_id" value="<?php echo (int)$categoryId; ?>">
                            <div class="col-12">
                                <label class="form-label">Archivo (player_id, seed)</label>
                                <input type="file" name="csv" class="form-control" accept=".csv" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-outline-primary">Importar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-responsive mt-4">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Jugador</th>
                            <th>Asociación</th>
                            <th>Seed</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($registrations as $registration): ?>
                        <tr>
                            <td><?php echo e($registration['player_name']); ?></td>
                            <td><?php echo e($registration['association_name']); ?></td>
                            <td><?php echo e($registration['ranking_seed']); ?></td>
                            <td>
                                <form method="post" action="/registrations/delete" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="category_id" value="<?php echo (int)$categoryId; ?>">
                                    <input type="hidden" name="player_id" value="<?php echo (int)$registration['player_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Quitar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
