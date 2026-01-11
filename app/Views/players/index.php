<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h3>Jugadores</h3>
        <a href="/players/create" class="btn primary">Nuevo jugador</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Asociación</th>
                <th>Seed</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($players as $player): ?>
            <tr>
                <td><?php echo e($player['name']); ?></td>
                <td><?php echo e($player['association_name']); ?></td>
                <td><?php echo e($player['ranking_seed']); ?></td>
                <td class="actions">
                    <a href="/players/edit?id=<?php echo (int)$player['id']; ?>" class="btn">Editar</a>
                    <form method="post" action="/players/delete" class="inline">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" value="<?php echo (int)$player['id']; ?>">
                        <button type="submit" class="btn danger">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
