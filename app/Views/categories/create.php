<?php
ob_start();
?>
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Crear categoría</h4>
            </div>
            <div class="card-body">
                <form method="post" action="<?= htmlspecialchars($baseUrl) ?>/categories">
                    <input type="hidden" name="tournament_id" value="<?= htmlspecialchars((string) $tournamentId) ?>">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jugadores por grupo</label>
                            <input type="number" class="form-control" name="players_per_group" value="4" min="2">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Clasifican por grupo</label>
                            <input type="number" class="form-control" name="qualify_per_group" value="2" min="1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Best of sets</label>
                            <input type="number" class="form-control" name="best_of_sets" value="5" min="1">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tamaño de llave</label>
                            <input type="number" class="form-control" name="bracket_size" value="16" min="2" max="128">
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Nueva categoría';
require __DIR__ . '/../layouts/main.php';
?>
