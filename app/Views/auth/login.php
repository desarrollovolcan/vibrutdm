<?php require __DIR__ . '/../partials/auth_header.php'; ?>
<main class="login-account">
    <div class="row h-100 g-0">
        <div class="col-lg-6 align-self-start d-none d-lg-block">
            <div class="account-info-area" style="background-image: url(/xhtml/assets/images/rainbow.gif)">
                <div class="login-content">
                    <p class="sub-title">Sistema de Torneo Tenis de Mesa</p>
                    <h1 class="title">Bienvenido a <span>Vibrutdm</span></h1>
                    <p class="text">Administra tus torneos, inscripciones y resultados desde un solo lugar.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-9 col-sm-12 mx-auto align-self-center">
            <div class="login-form">
                <div class="login-head">
                    <h3 class="title">Iniciar sesión</h3>
                    <p class="fs-16">Ingresa tus credenciales para continuar.</p>
                </div>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo e($error); ?></div>
                <?php endif; ?>
                <form method="post" action="/login">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input id="email" type="email" name="email" class="form-control form-control-lg" placeholder="tu@email.com" value="<?php echo e($email ?? ''); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Contraseña</label>
                        <input id="password" type="password" name="password" class="form-control form-control-lg" placeholder="••••••••" required>
                    </div>
                    <div class="text-center mb-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100">Entrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../partials/auth_footer.php'; ?>
