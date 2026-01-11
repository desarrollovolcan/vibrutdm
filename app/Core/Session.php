<?php

declare(strict_types=1);

namespace App\Core;

class Session
{
    public static function start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public static function token(): string
    {
        if (!isset($_SESSION['_token'])) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_token'];
    }

    public static function validateToken(?string $token): bool
    {
        return $token !== null && hash_equals($_SESSION['_token'] ?? '', $token);
    }

    public static function login(array $user): void
    {
        $_SESSION['user'] = $user;
    }

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function logout(): void
    {
        unset($_SESSION['user']);
    }
}
