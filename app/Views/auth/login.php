<?php
$title = 'Iniciar sesión';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.avif">
    <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body class="vh-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <img src="/assets/images/logo-text.png" alt="">
                                    </div>
                                    <h4 class="text-center mb-4">Acceso al sistema</h4>
                                    <?php if (!empty($error)) : ?>
                                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                                    <?php endif; ?>
                                    <form method="post" action="/login">
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" class="form-control" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Contraseña</strong></label>
                                            <input type="password" class="form-control" name="password" required>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="/assets/vendor/global/global.min.js"></script>
<script src="/assets/js/custom.min.js"></script>
</body>
</html>
