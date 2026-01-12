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
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon.avif">
    <link href="/assets/vendor/metismenu/dist/metisMenu.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="/assets/css/plugins.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
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
        <a href="/dashboard" class="brand-logo">
            <img class="logo-abbr" src="/assets/images/logo.png" alt="">
            <img class="logo-compact" src="/assets/images/logo-text.png" alt="">
            <img class="brand-title" src="/assets/images/logo-text.png" alt="">
        </a>
        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>

    <div class="dlabnav">
        <div class="dlabnav-scroll">
            <ul class="metismenu" id="menu">
                <li><a href="/dashboard" class="ai-icon"><i class="la la-home"></i><span class="nav-text">Dashboard</span></a></li>
                <li><a href="/tournaments" class="ai-icon"><i class="la la-trophy"></i><span class="nav-text">Torneos</span></a></li>
                <li><a href="/players" class="ai-icon"><i class="la la-users"></i><span class="nav-text">Jugadores</span></a></li>
                <li><a href="/categories" class="ai-icon"><i class="la la-list"></i><span class="nav-text">Categorías</span></a></li>
                <li><a href="/registrations" class="ai-icon"><i class="la la-user-plus"></i><span class="nav-text">Inscripciones</span></a></li>
                <li><a href="/groups" class="ai-icon"><i class="la la-object-group"></i><span class="nav-text">Grupos</span></a></li>
                <li><a href="/brackets" class="ai-icon"><i class="la la-sitemap"></i><span class="nav-text">Llaves</span></a></li>
                <li><a href="/logout" class="ai-icon"><i class="la la-sign-out"></i><span class="nav-text">Salir</span></a></li>
            </ul>
        </div>
    </div>

    <div class="content-body">
        <div class="container-fluid">
            <?= $content ?>
        </div>
    </div>
</div>

<script src="/assets/vendor/global/global.min.js"></script>
<script src="/assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="/assets/vendor/metismenu/dist/metisMenu.min.js"></script>
<script src="/assets/js/custom.min.js"></script>
<script src="/assets/js/dlabnav-init.js"></script>
</body>
</html>
