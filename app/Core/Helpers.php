<?php

declare(strict_types=1);

use App\Core\Session;

function env(string $key, ?string $default = null): ?string
{
    $value = $_ENV[$key] ?? getenv($key);
    return $value === false || $value === null ? $default : $value;
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function view(string $view, array $data = []): void
{
    extract($data);
    $viewFile = __DIR__ . '/../Views/' . $view . '.php';
    if (!file_exists($viewFile)) {
        http_response_code(500);
        echo 'View not found: ' . e($view);
        return;
    }
    require $viewFile;
}

function csrf_token(): string
{
    return Session::token();
}

function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . e(csrf_token()) . '">';
}

function current_user(): ?array
{
    return Session::user();
}

function has_role(string $role): bool
{
    $user = current_user();
    return $user && $user['role'] === $role;
}

function require_role(array $roles): void
{
    $user = current_user();
    if (!$user || !in_array($user['role'], $roles, true)) {
        http_response_code(403);
        view('errors/403');
        exit;
    }
}
