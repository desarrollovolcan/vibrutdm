<?php
$user = current_user();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenis de Mesa - Torneos</title>
    <link rel="icon" type="image/png" sizes="16x16" href="/xhtml/assets/images/favicon.avif">
    <link rel="stylesheet" href="/xhtml/assets/vendor/metismenu/dist/metisMenu.min.css">
    <link rel="stylesheet" href="/xhtml/assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="/xhtml/assets/vendor/jqvmap/css/jqvmap.min.css">
    <link rel="stylesheet" href="/xhtml/assets/vendor/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="/xhtml/assets/css/switcher.css">
    <link class="main-plugins" rel="stylesheet" href="/xhtml/assets/css/plugins.css">
    <link class="main-css" rel="stylesheet" href="/xhtml/assets/css/style.css">
    <link rel="stylesheet" href="/theme/css/app.css">
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
        <a href="/" class="brand-logo">
            <img class="logo-abbr" src="/xhtml/assets/images/logo.png" alt="Logo">
            <img class="logo-compact" src="/xhtml/assets/images/logo-text.png" alt="Tenis de Mesa">
            <img class="brand-title" src="/xhtml/assets/images/logo-text.png" alt="Tenis de Mesa">
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
                        <div class="dashboard_bar">Panel de Torneos</div>
                    </div>
                    <ul class="navbar-nav header-right">
                        <?php if ($user): ?>
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown">
                                    <div class="header-info">
                                        <span class="text-black">Hola, <strong><?php echo e($user['name']); ?></strong></span>
                                        <p class="fs-12 mb-0"><?php echo e($user['role']); ?></p>
                                    </div>
                                    <img src="/xhtml/assets/images/profile/17.webp" width="20" alt="Perfil">
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="/logout" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        <span class="ms-2">Salir</span>
                                    </a>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="deznav">
        <div class="deznav-scroll">
            <ul class="metismenu" id="menu">
                <li>
                    <a href="/" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-381-home"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <?php if ($user): ?>
                    <?php if (in_array($user['role'], ['ADMIN', 'OPERADOR'], true)): ?>
                        <li>
                            <a href="/tournaments" class="ai-icon" aria-expanded="false">
                                <i class="flaticon-381-networking"></i>
                                <span class="nav-text">Torneos</span>
                            </a>
                        </li>
                        <li>
                            <a href="/categories" class="ai-icon" aria-expanded="false">
                                <i class="flaticon-381-tag"></i>
                                <span class="nav-text">Categorías</span>
                            </a>
                        </li>
                        <li>
                            <a href="/associations" class="ai-icon" aria-expanded="false">
                                <i class="flaticon-381-user-7"></i>
                                <span class="nav-text">Asociaciones</span>
                            </a>
                        </li>
                        <li>
                            <a href="/players" class="ai-icon" aria-expanded="false">
                                <i class="flaticon-381-user-6"></i>
                                <span class="nav-text">Jugadores</span>
                            </a>
                        </li>
                        <li>
                            <a href="/registrations" class="ai-icon" aria-expanded="false">
                                <i class="flaticon-381-clipboard"></i>
                                <span class="nav-text">Inscripciones</span>
                            </a>
                        </li>
                        <li>
                            <a href="/groups" class="ai-icon" aria-expanded="false">
                                <i class="flaticon-381-layer-1"></i>
                                <span class="nav-text">Grupos</span>
                            </a>
                        </li>
                        <li>
                            <a href="/brackets" class="ai-icon" aria-expanded="false">
                                <i class="flaticon-381-star"></i>
                                <span class="nav-text">Llave</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if ($user['role'] === 'ADMIN'): ?>
                        <li>
                            <a href="/users" class="ai-icon" aria-expanded="false">
                                <i class="flaticon-381-user"></i>
                                <span class="nav-text">Usuarios</span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <li>
                    <a href="/logout" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-381-exit"></i>
                        <span class="nav-text">Salir</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="content-body default-height">
        <div class="container-fluid">
