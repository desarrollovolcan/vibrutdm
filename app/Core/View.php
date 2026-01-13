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
        $baseUrl = $basePath . '/index.php';
        require __DIR__ . '/../Views/' . $view . '.php';
    }
}
