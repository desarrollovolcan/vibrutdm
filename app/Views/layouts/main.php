<?php
$title = $title ?? 'VMC Ping Pong';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?= htmlspecialchars($basePath) ?>/assets/images/favicon.avif">
    <link href="<?= htmlspecialchars($basePath) ?>/assets/vendor/metismenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="<?= htmlspecialchars($basePath) ?>/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="<?= htmlspecialchars($basePath) ?>/assets/css/plugins.css" rel="stylesheet">
    <link href="<?= htmlspecialchars($basePath) ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>

<div id="main-wrapper">
    <div class="nav-header">
        <a href="<?= htmlspecialchars($baseUrl) ?>/dashboard" class="brand-logo">
            <img class="logo-abbr" src="<?= htmlspecialchars($basePath) ?>/assets/images/logo.png" alt="">
            <img class="logo-compact" src="<?= htmlspecialchars($basePath) ?>/assets/images/logo-text.png" alt="">
            <img class="brand-title" src="<?= htmlspecialchars($basePath) ?>/assets/images/logo-text.png" alt="">
        </a>
        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>

    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">Panel de control</div>
                    </div>
                    <ul class="navbar-nav header-right">
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="<?= htmlspecialchars($baseUrl) ?>/logout">
                                <span class="text-end">
                                    <span class="d-block font-w600">Cerrar sesión</span>
                                    <small class="text-muted">Administrador</small>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <div class="deznav">
        <div class="deznav-scroll">
            <ul class="metismenu" id="menu">
                <li><a href="<?= htmlspecialchars($baseUrl) ?>/dashboard" class="ai-icon"><i class="flaticon-381-home-2"></i><span class="nav-text">Dashboard</span></a></li>
                <li><a href="<?= htmlspecialchars($baseUrl) ?>/tournaments" class="ai-icon"><i class="flaticon-381-rocket"></i><span class="nav-text">Torneos</span></a></li>
                <li><a href="<?= htmlspecialchars($baseUrl) ?>/categories" class="ai-icon"><i class="flaticon-381-list"></i><span class="nav-text">Categorías</span></a></li>
                <li><a href="<?= htmlspecialchars($baseUrl) ?>/players" class="ai-icon"><i class="flaticon-381-user"></i><span class="nav-text">Jugadores</span></a></li>
                <li><a href="<?= htmlspecialchars($baseUrl) ?>/registrations" class="ai-icon"><i class="flaticon-381-add-1"></i><span class="nav-text">Inscripciones</span></a></li>
                <li><a href="<?= htmlspecialchars($baseUrl) ?>/groups" class="ai-icon"><i class="flaticon-381-layer-1"></i><span class="nav-text">Grupos</span></a></li>
                <li><a href="<?= htmlspecialchars($baseUrl) ?>/matches" class="ai-icon"><i class="flaticon-381-stopwatch"></i><span class="nav-text">Partidos</span></a></li>
                <li><a href="<?= htmlspecialchars($baseUrl) ?>/results/edit" class="ai-icon"><i class="flaticon-381-edit"></i><span class="nav-text">Resultados</span></a></li>
                <li><a href="<?= htmlspecialchars($baseUrl) ?>/brackets" class="ai-icon"><i class="flaticon-381-network"></i><span class="nav-text">Llaves</span></a></li>
                <li><a href="<?= htmlspecialchars($baseUrl) ?>/logout" class="ai-icon"><i class="flaticon-381-exit"></i><span class="nav-text">Salir</span></a></li>
            </ul>
        </div>
    </div>

    <main class="content-body default-height">
        <div class="container-fluid">
            <?= $content ?>
        </div>
    </main>
</div>

<script src="<?= htmlspecialchars($basePath) ?>/assets/vendor/global/global.min.js"></script>
<script src="<?= htmlspecialchars($basePath) ?>/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="<?= htmlspecialchars($basePath) ?>/assets/vendor/metismenu/dist/metisMenu.min.js"></script>
<script src="<?= htmlspecialchars($basePath) ?>/assets/js/custom.min.js"></script>
<script src="<?= htmlspecialchars($basePath) ?>/assets/js/deznav-init.js"></script>
</body>
</html>
