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
        $indexPrefix = $basePath . '/index.php';
        $baseUrl = ($requestPath && str_starts_with($requestPath, $indexPrefix)) ? $indexPrefix : $basePath;
        require __DIR__ . '/../Views/' . $view . '.php';
    }
}
