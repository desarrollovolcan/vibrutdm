<?php

declare(strict_types=1);

$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/');
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
if ($basePath !== '' && str_starts_with($requestUri, $basePath)) {
    $trimmed = substr($requestUri, strlen($basePath));
    $_SERVER['REQUEST_URI'] = $trimmed === '' ? '/' : $trimmed;
}

require __DIR__ . '/public/index.php';
