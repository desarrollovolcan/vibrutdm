<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, callable $handler, array $roles = []): void
    {
        $this->map('GET', $path, $handler, $roles);
    }

    public function post(string $path, callable $handler, array $roles = []): void
    {
        $this->map('POST', $path, $handler, $roles);
    }

    private function map(string $method, string $path, callable $handler, array $roles): void
    {
        $this->routes[] = compact('method', 'path', 'handler', 'roles');
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                if (!empty($route['roles'])) {
                    require_role($route['roles']);
                }
                call_user_func($route['handler']);
                return;
            }
        }
        http_response_code(404);
        view('errors/404');
    }
}
