<?php

namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    protected function redirect(string $path): void
    {
        $target = $path;
        if (!str_starts_with($path, 'http://') && !str_starts_with($path, 'https://')) {
            $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
            $basePath = rtrim(dirname($scriptName), '/');
            if ($basePath === '/' || $basePath === '.') {
                $basePath = '';
            }
            $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';
            if ($basePath === '' && $requestPath !== '') {
                if (str_contains($requestPath, '/index.php')) {
                    $beforeIndex = strstr($requestPath, '/index.php', true);
                    if ($beforeIndex !== false && $beforeIndex !== '') {
                        $basePath = $beforeIndex;
                    }
                } else {
                    $segments = explode('/', trim($requestPath, '/'));
                    if (!empty($segments[0])) {
                        $basePath = '/' . $segments[0];
                    }
                }
            }
            $baseUrl = $basePath . '/index.php';
            if (str_starts_with($path, '/')) {
                $target = $baseUrl . $path;
            } else {
                $target = $baseUrl . '/' . $path;
            }
        }

        header('Location: ' . $target);
        exit;
    }
}
