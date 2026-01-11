<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Torneos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Sede</th>
                                <th>Inicio</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($tournaments as $tournament): ?>
                            <tr>
                                <td><?php echo e($tournament['name']); ?></td>
                                <td><?php echo e($tournament['venue']); ?></td>
                                <td><?php echo e($tournament['date_start']); ?></td>
                                <td><?php echo e($tournament['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Partidos recientes</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Fase</th>
                                <th>Jugador A</th>
                                <th>Jugador B</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($upcomingMatches as $match): ?>
                            <tr>
                                <td><?php echo e($match['phase']); ?></td>
                                <td><?php echo e($match['player_a_name']); ?></td>
                                <td><?php echo e($match['player_b_name']); ?></td>
                                <td><?php echo e($match['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
