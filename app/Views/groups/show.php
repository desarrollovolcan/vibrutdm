<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Detalle de grupo</h3>
    <div class="grid two">
        <div>
            <h4>Jugadores</h4>
            <ul class="list">
                <?php foreach ($players as $player): ?>
                    <li><?php echo e($player['player_name']); ?> (<?php echo e($player['association_name']); ?>)</li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div>
            <h4>Standings</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Jugador</th>
                        <th>PG</th>
                        <th>PP</th>
                        <th>SW</th>
                        <th>SL</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($standings as $row): ?>
                    <tr>
                        <td><?php echo e($row['rank_pos']); ?></td>
                        <td><?php echo e($row['player_name']); ?></td>
                        <td><?php echo e($row['matches_won']); ?></td>
                        <td><?php echo e($row['matches_lost']); ?></td>
                        <td><?php echo e($row['sets_won']); ?></td>
                        <td><?php echo e($row['sets_lost']); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <form method="post" action="/groups/recalc">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="group_id" value="<?php echo (int)($group['id'] ?? 0); ?>">
                <input type="hidden" name="category_id" value="<?php echo (int)($_GET['category_id'] ?? 0); ?>">
                <button type="submit" class="btn">Recalcular standings</button>
            </form>
        </div>
    </div>

    <h4>Partidos</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Jugador A</th>
                <th>Jugador B</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($matches as $match): ?>
            <tr>
                <td><?php echo e($match['player_a_name']); ?></td>
                <td><?php echo e($match['player_b_name']); ?></td>
                <td><?php echo e($match['status']); ?></td>
                <td><a href="/matches/edit?id=<?php echo (int)$match['id']; ?>&redirect_to=<?php echo urlencode('/groups/show?id=' . (int)$match['group_id'] . '&category_id=' . (int)($_GET['category_id'] ?? 0)); ?>" class="btn">Cargar resultado</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
