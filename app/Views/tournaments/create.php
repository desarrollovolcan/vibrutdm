<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Nuevo torneo</h3>
    <form method="post" action="/tournaments/store" class="form-grid">
        <?php echo csrf_field(); ?>
        <label>Nombre
            <input type="text" name="name" required>
        </label>
        <label>Sede
            <input type="text" name="venue" required>
        </label>
        <label>Fecha inicio
            <input type="date" name="date_start" required>
        </label>
        <label>Estado
            <select name="status">
                <option value="borrador">Borrador</option>
                <option value="en_curso">En curso</option>
                <option value="finalizado">Finalizado</option>
            </select>
        </label>
        <button type="submit" class="btn primary">Guardar</button>
    </form>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
