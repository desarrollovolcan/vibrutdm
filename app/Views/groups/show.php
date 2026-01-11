<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Detalle de grupo</h5>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-xl-4">
                <h6 class="mb-3">Jugadores</h6>
                <ul class="list-group">
                    <?php foreach ($players as $player): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?php echo e($player['player_name']); ?></span>
                            <span class="text-muted"><?php echo e($player['association_name']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-xl-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">Standings</h6>
                    <form method="post" action="/groups/recalc">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="group_id" value="<?php echo (int)($group['id'] ?? 0); ?>">
                        <input type="hidden" name="category_id" value="<?php echo (int)($_GET['category_id'] ?? 0); ?>">
                        <button type="submit" class="btn btn-outline-primary btn-sm">Recalcular</button>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
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
                </div>
            </div>
        </div>

        <h6 class="mt-4 mb-3">Partidos</h6>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
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
                        <td><a href="/matches/edit?id=<?php echo (int)$match['id']; ?>&redirect_to=<?php echo urlencode('/groups/show?id=' . (int)$match['group_id'] . '&category_id=' . (int)($_GET['category_id'] ?? 0)); ?>" class="btn btn-light btn-sm">Cargar resultado</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
