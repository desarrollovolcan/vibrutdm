<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Nuevo torneo</h5>
    </div>
    <div class="card-body">
        <form method="post" action="/tournaments/store" class="row g-3">
            <?php echo csrf_field(); ?>
            <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Sede</label>
                <input type="text" name="venue" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Fecha inicio</label>
                <input type="date" name="date_start" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Estado</label>
                <select name="status" class="form-select">
                    <option value="borrador">Borrador</option>
                    <option value="en_curso">En curso</option>
                    <option value="finalizado">Finalizado</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
