<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Editar torneo</h3>
    <?php if ($tournament): ?>
        <form method="post" action="/tournaments/update" class="form-grid">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="id" value="<?php echo (int)$tournament['id']; ?>">
            <label>Nombre
                <input type="text" name="name" value="<?php echo e($tournament['name']); ?>" required>
            </label>
            <label>Sede
                <input type="text" name="venue" value="<?php echo e($tournament['venue']); ?>" required>
            </label>
            <label>Fecha inicio
                <input type="date" name="date_start" value="<?php echo e($tournament['date_start']); ?>" required>
            </label>
            <label>Estado
                <select name="status">
                    <?php foreach (['borrador' => 'Borrador', 'en_curso' => 'En curso', 'finalizado' => 'Finalizado'] as $value => $label): ?>
                        <option value="<?php echo $value; ?>" <?php echo $tournament['status'] === $value ? 'selected' : ''; ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <button type="submit" class="btn primary">Guardar</button>
        </form>
    <?php else: ?>
        <p>Torneo no encontrado.</p>
    <?php endif; ?>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
