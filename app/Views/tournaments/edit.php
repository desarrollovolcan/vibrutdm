<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Editar torneo</h5>
    </div>
    <div class="card-body">
        <?php if ($tournament): ?>
            <form method="post" action="/tournaments/update" class="row g-3">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo (int)$tournament['id']; ?>">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e($tournament['name']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sede</label>
                    <input type="text" name="venue" class="form-control" value="<?php echo e($tournament['venue']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fecha inicio</label>
                    <input type="date" name="date_start" class="form-control" value="<?php echo e($tournament['date_start']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <?php foreach (['borrador' => 'Borrador', 'en_curso' => 'En curso', 'finalizado' => 'Finalizado'] as $value => $label): ?>
                            <option value="<?php echo $value; ?>" <?php echo $tournament['status'] === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        <?php else: ?>
            <p class="mb-0">Torneo no encontrado.</p>
        <?php endif; ?>
    </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
