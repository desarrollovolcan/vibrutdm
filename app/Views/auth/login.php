<?php require __DIR__ . '/../partials/auth_header.php'; ?>
<main class="login-account">
    <div class="row h-100">
        <div class="col-lg-6 align-self-start d-none d-lg-block">
            <div class="account-info-area" style="background-image: url(/xhtml/assets/images/rainbow.gif)">
                <div class="login-content">
                    <p class="sub-title">Sistema de Torneo Tenis de Mesa</p>
                    <h1 class="title">Bienvenido a <span>Vibrutdm</span></h1>
                    <p class="text">Administra tus torneos, inscripciones y resultados desde un solo lugar.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-7 col-sm-12 mx-auto align-self-center">
            <div class="login-form">
                <div class="login-head">
                    <h3 class="title">Bienvenido de vuelta</h3>
                    <p class="fs-16">Ingresa tus credenciales para continuar.</p>
                </div>
                <h6 class="login-title"><span>Acceso</span></h6>
                <div class="row mb-5">
                    <div class="col-xl-6 col-sm-6">
                        <a href="javascript:void(0);" class="btn btn-outline-danger d-block social-btn">
                            <span class="ms-1 fs-16 fw-medium">Acceder con Google</span>
                        </a>
                    </div>
                    <div class="col-xl-6 col-sm-6">
                        <a href="javascript:void(0);" class="btn btn-outline-black d-block apple social-btn">
                            <span class="ms-1 fs-16 fw-medium">Acceder con Apple</span>
                        </a>
                    </div>
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
                        <div class="position-relative">
                            <input id="password" type="password" name="password" class="form-control form-control-lg dz-password" placeholder="••••••••" required>
                            <span class="show-pass position-absolute top-50 end-0 me-2 translate-middle">
                                <span class="show"><i class="fa fa-eye-slash"></i></span>
                                <span class="hide"><i class="fa fa-eye"></i></span>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap justify-content-between mb-4 mb-lg-5">
                        <div class="form-check custom-checkbox mb-0">
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label class="form-check-label fs-16" for="rememberMe">Recordarme</label>
                        </div>
                        <a href="javascript:void(0);" class="btn-link text-primary fs-16">¿Olvidaste tu contraseña?</a>
                    </div>
                    <div class="text-center mb-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">Iniciar sesión</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php require __DIR__ . '/../partials/auth_footer.php'; ?>
