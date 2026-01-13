<?php

namespace App\Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data);
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
        require __DIR__ . '/../Views/' . $view . '.php';
    }
}
