<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="grid two">
    <div class="card">
        <h3>Torneos</h3>
        <table class="table">
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
    <div class="card">
        <h3>Partidos recientes</h3>
        <table class="table">
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
<?php require __DIR__ . '/../partials/footer.php'; ?>
