<?php
ob_start();
?>
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Crear torneo</h4>
            </div>
            <div class="card-body">
                <form method="post" action="<?= htmlspecialchars($baseUrl) ?>/tournaments">
                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ubicación</label>
                        <input type="text" class="form-control" name="location">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Inicio</label>
                            <input type="date" class="form-control" name="start_date">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fin</label>
                            <input type="date" class="form-control" name="end_date">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select class="form-control" name="status">
                            <option value="draft">Borrador</option>
                            <option value="active">Activo</option>
                            <option value="closed">Cerrado</option>
                        </select>
                    </div>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
$title = 'Nuevo torneo';
require __DIR__ . '/../layouts/main.php';
?>
