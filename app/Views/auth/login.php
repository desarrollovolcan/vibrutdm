<?php require __DIR__ . '/../partials/auth_header.php'; ?>
<main class="login-account">
    <div class="row h-100">
        <div class="col-lg-6 align-self-start d-none d-lg-block">
            <div class="account-info-area" style="background-image: url(/xhtml/assets/images/rainbow.gif); background-color: var(--primary);">
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
                            <svg width="16" height="16" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27.9851 14.2618C27.9851 13.1146 27.8899 12.2775 27.6837 11.4094H14.2788V16.5871H22.1472C21.9886 17.8738 21.132 19.8116 19.2283 21.1137L19.2016 21.287L23.44 24.4956L23.7336 24.5242C26.4304 22.0904 27.9851 18.5093 27.9851 14.2618Z" fill="#4285F4"></path>
                                <path d="M14.279 27.904C18.1338 27.904 21.37 26.6637 23.7338 24.5245L19.2285 21.114C18.0228 21.9356 16.4047 22.5092 14.279 22.5092C10.5034 22.5092 7.29894 20.0754 6.15663 16.7114L5.9892 16.7253L1.58205 20.0583L1.52441 20.2149C3.87224 24.7725 8.69486 27.904 14.279 27.904Z" fill="#34A853"></path>
                                <path d="M6.15656 16.7113C5.85516 15.8432 5.68072 14.913 5.68072 13.9519C5.68072 12.9907 5.85516 12.0606 6.14071 11.1925L6.13272 11.0076L1.67035 7.62109L1.52435 7.68896C0.556704 9.58024 0.00146484 11.7041 0.00146484 13.9519C0.00146484 16.1997 0.556704 18.3234 1.52435 20.2147L6.15656 16.7113Z" fill="#FBBC05"></path>
                                <path d="M14.279 5.3947C16.9599 5.3947 18.7683 6.52635 19.7995 7.47204L23.8289 3.6275C21.3542 1.37969 18.1338 0 14.279 0C8.69485 0 3.87223 3.1314 1.52441 7.68899L6.14077 11.1925C7.29893 7.82856 10.5034 5.3947 14.279 5.3947Z" fill="#EB4335"></path>
                            </svg>
                            <span class="ms-1 fs-16 fw-medium">Acceder con Google</span>
                        </a>
                    </div>
                    <div class="col-xl-6 col-sm-6">
                        <a href="javascript:void(0);" class="btn btn-outline-black d-block apple social-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 456.008 560.035">
                                <path d="M380.844 297.529c.787 84.752 74.349 112.955 75.164 113.314-.622 1.988-11.754 40.191-38.756 79.652-23.343 34.117-47.568 68.107-85.731 68.811-37.499.691-49.557-22.236-92.429-22.236-42.859 0-56.256 21.533-91.753 22.928-36.837 1.395-64.889-36.891-88.424-70.883-48.093-69.53-84.846-196.475-35.496-282.165 24.516-42.554 68.328-69.501 115.882-70.192 36.173-.69 70.315 24.336 92.429 24.336 22.1 0 63.59-30.096 107.208-25.676 18.26.76 69.517 7.376 102.429 55.552-2.652 1.644-61.159 35.704-60.523 106.559M310.369 89.418C329.926 65.745 343.089 32.79 339.498 0 311.308 1.133 277.22 18.785 257 42.445c-18.121 20.952-33.991 54.487-29.709 86.628 31.421 2.431 63.52-15.967 83.078-39.655"></path>
                            </svg>
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
                        <input id="email" type="email" name="email" class="form-control form-control-lg" placeholder="tu@email.com" value="<?php echo e($email ?? ''); ?>" autocomplete="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Contraseña</label>
                        <div class="position-relative">
                            <input id="password" type="password" name="password" class="form-control form-control-lg dz-password" placeholder="••••••••" autocomplete="current-password" required>
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
