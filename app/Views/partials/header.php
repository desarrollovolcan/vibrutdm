<?php
$user = current_user();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenis de Mesa - Torneos</title>
    <link rel="stylesheet" href="/theme/css/theme.css">
</head>
<body>
<div class="app-wrapper">
    <aside class="app-sidebar">
        <div class="sidebar-header">
            <span class="brand">Tenis de Mesa</span>
        </div>
        <nav class="sidebar-nav">
            <a href="/" class="sidebar-link">Dashboard</a>
            <?php if ($user): ?>
                <?php if (in_array($user['role'], ['ADMIN', 'OPERADOR'], true)): ?>
                    <a href="/tournaments" class="sidebar-link">Torneos</a>
                    <a href="/categories" class="sidebar-link">Categorías</a>
                    <a href="/associations" class="sidebar-link">Asociaciones</a>
                    <a href="/players" class="sidebar-link">Jugadores</a>
                    <a href="/registrations" class="sidebar-link">Inscripciones</a>
                    <a href="/groups" class="sidebar-link">Grupos</a>
                    <a href="/brackets" class="sidebar-link">Llave</a>
                <?php endif; ?>
                <?php if ($user['role'] === 'ADMIN'): ?>
                    <a href="/users" class="sidebar-link">Usuarios</a>
                <?php endif; ?>
            <?php endif; ?>
            <a href="/logout" class="sidebar-link">Salir</a>
        </nav>
    </aside>
    <main class="app-content">
        <header class="app-header">
            <div class="header-left">
                <h1>Panel de Torneos</h1>
            </div>
            <div class="header-right">
                <?php if ($user): ?>
                    <span class="user-pill"><?php echo e($user['name']); ?> (<?php echo e($user['role']); ?>)</span>
                <?php endif; ?>
            </div>
        </header>
        <section class="app-body">
