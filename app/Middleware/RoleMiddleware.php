<?php

namespace App\Middleware;

class RoleMiddleware
{
    public function handle(array $rolesPermitidos): void
    {
        $role = $_SESSION['user']['role'] ?? null;
        if (!in_array($role, $rolesPermitidos, true)) {
            http_response_code(403);
            echo '403 - Acceso denegado';
            exit;
        }
    }
}
