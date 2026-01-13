<?php

session_start();

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
if (!isset($_SESSION['user']) && !in_array($path, ['/', '/login'], true)) {
    $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $basePath = rtrim(dirname($scriptName), '/');
    if ($basePath === '/' || $basePath === '.') {
        $basePath = '';
    }
    if ($basePath === '' && $path !== '') {
        if (str_contains($path, '/index.php')) {
            $beforeIndex = strstr($path, '/index.php', true);
            if ($beforeIndex !== false && $beforeIndex !== '') {
                $basePath = $beforeIndex;
            }
        } else {
            $segments = explode('/', trim($path, '/'));
            if (!empty($segments[0])) {
                $basePath = '/' . $segments[0];
            }
        }
    }
    $baseUrl = $basePath . '/index.php';
    header('Location: ' . $baseUrl . '/login');
    exit;
}

$router = require __DIR__ . '/../routes/web.php';
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
