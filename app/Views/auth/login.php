<?php
$title = 'Acceso al sistema';
?>
<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.avif">
    <link href="/assets/vendor/metismenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="/assets/css/plugins.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body class="h-100">
    <main class="login-account">
        <div class="row h-100">
            <div class="col-lg-6 align-self-start">
                <div class="account-info-area" style="background-image: url(/assets/images/rainbow.gif)">
                    <div class="login-content">
                        <p class="sub-title">Ingresa con tus credenciales de administrador</p>
                        <h1 class="title">Gestión de <span>Torneos</span></h1>
                        <p class="text">Administra torneos, categorías, grupos y resultados desde un solo panel.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-7 col-sm-12 mx-auto align-self-center">
                <div class="login-form">
                    <div class="login-head">
                        <h3 class="title">Bienvenido</h3>
                        <p class="fs-16">Usa el acceso admin/admin123 para comenzar.</p>
                    </div>
                    <h6 class="login-title"><span>Iniciar sesión</span></h6>
                    <?php if (!empty($error)) : ?>
                        <div class="alert alert-danger mb-4"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <form method="post" action="/login">
                        <div class="mb-3">
                            <label class="form-label">Usuario</label>
                            <input type="text" class="form-control form-control-lg" name="email" placeholder="admin" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Contraseña</label>
                            <div class="position-relative">
                                <input type="password" class="form-control form-control-lg dz-password" name="password" placeholder="admin123" required>
                                <span class="show-pass position-absolute top-50 end-0 me-2 translate-middle">
                                    <span class="show"><i class="fa fa-eye-slash"></i></span>
                                    <span class="hide"><i class="fa fa-eye"></i></span>
                                </span>
                            </div>
                        </div>
                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Ingresar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="/assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="/assets/vendor/metismenu/dist/metisMenu.min.js"></script>
    <script src="/assets/js/deznav-init.js"></script>
    <script src="/assets/js/custom.js"></script>
</body>
</html>
