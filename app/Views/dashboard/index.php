<?php
ob_start();
?>
<div class="mb-4">
    <h2 class="text-black fw-semibold mb-0">Dashboard</h2>
    <p class="text-muted">Resumen general del campeonato.</p>
</div>
<div class="row">
    <div class="col-xl-8 col-lg-7 col-md-12">
        <div class="card-bx stacked position-relative z-1 d-block w-100 mb-4">
            <img src="/assets/images/card/card.avif" alt="" class="position-absolute h-100 w-100 z-0 rounded-3 object-fit-cover">
            <div class="position-relative py-5 px-4 text-white">
                <p class="mb-1 text-white fs-16">Torneos activos</p>
                <h2 class="fs-36 text-white lh-sm mb-sm-4 mb-3"><?= count($tournaments) ?></h2>
                <div class="d-flex align-items-center justify-content-between mb-sm-5 mb-3">
                    <img src="/assets/images/dual-dot.avif" alt="" class="width60">
                    <h4 class="fs-20 text-white mb-0">Gestión en tiempo real</h4>
                </div>
                <div class="d-flex">
                    <div class="me-5">
                        <p class="fs-14 mb-1 text-white text-opacity-50">ESTADO</p>
                        <span class="fs-16">Configuración lista</span>
                    </div>
                    <div>
                        <p class="fs-14 mb-1 text-white text-opacity-50">USUARIO</p>
                        <span class="fs-16"><?= htmlspecialchars($_SESSION['user']['name'] ?? 'Admin') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5 col-md-12">
        <div class="card bg-primary bg-opacity-10 card-body overflow-hidden border-0">
            <div class="text-center">
                <span class="fs-16 text-black">Panel rápido</span>
                <h3 class="text-black fs-20 mb-0 fw-semibold"><?= count($tournaments) ?> torneos</h3>
                <small class="fs-14">Configura grupos y llaves</small>
            </div>
            <canvas id="lineChart" height="180" class="mt-3 line-chart-demo"></canvas>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Torneos registrados</h4>
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
