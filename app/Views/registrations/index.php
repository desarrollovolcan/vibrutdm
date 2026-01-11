<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Inscripciones</h3>
    <form method="get" action="/registrations" class="form-inline">
        <label>Categoría
            <select name="category_id" onchange="this.form.submit()">
                <option value="">Seleccione</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo (int)$category['id']; ?>" <?php echo (int)$categoryId === (int)$category['id'] ? 'selected' : ''; ?>><?php echo e($category['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
    </form>

    <?php if ($categoryId): ?>
        <div class="grid two">
            <form method="post" action="/registrations/store" class="form-grid">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="category_id" value="<?php echo (int)$categoryId; ?>">
                <label>Jugador
                    <select name="player_id" required>
                        <?php foreach ($players as $player): ?>
                            <option value="<?php echo (int)$player['id']; ?>"><?php echo e($player['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label>Seed
                    <input type="number" name="ranking_seed">
                </label>
                <button type="submit" class="btn primary">Agregar</button>
            </form>

            <form method="post" action="/registrations/import" enctype="multipart/form-data" class="form-grid">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="category_id" value="<?php echo (int)$categoryId; ?>">
                <label>Importar CSV (player_id, seed)
                    <input type="file" name="csv" accept=".csv" required>
                </label>
                <button type="submit" class="btn">Importar</button>
            </form>
        </div>

        <table class="table">
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
                        <form method="post" action="/registrations/delete" class="inline">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="category_id" value="<?php echo (int)$categoryId; ?>">
                            <input type="hidden" name="player_id" value="<?php echo (int)$registration['player_id']; ?>">
                            <button type="submit" class="btn danger">Quitar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
