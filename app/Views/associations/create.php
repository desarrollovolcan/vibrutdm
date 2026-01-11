<?php require __DIR__ . '/../partials/header.php'; ?>
<div class="card">
    <h3>Nueva asociación</h3>
    <form method="post" action="/associations/store" class="form-grid">
        <?php echo csrf_field(); ?>
        <label>Nombre
            <input type="text" name="name" required>
        </label>
        <button type="submit" class="btn primary">Guardar</button>
    </form>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
