<?php require __DIR__ . '/../partials/auth_header.php'; ?>
<div class="auth-card">
    <h2>Iniciar sesión</h2>
    <?php if (!empty($error)): ?>
        <div class="alert error"><?php echo e($error); ?></div>
    <?php endif; ?>
    <form method="post" action="/login" class="form-stack">
        <?php echo csrf_field(); ?>
        <label>Email
            <input type="email" name="email" value="<?php echo e($email ?? ''); ?>" required>
        </label>
        <label>Contraseña
            <input type="password" name="password" required>
        </label>
        <button type="submit" class="btn primary">Entrar</button>
    </form>
</div>
<?php require __DIR__ . '/../partials/auth_footer.php'; ?>
