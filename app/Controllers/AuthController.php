<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Session;
use App\Models\User;

class AuthController
{
    public function showLogin(): void
    {
        view('auth/login');
    }

    public function login(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);
        if (!$user || !$user['is_active'] || !password_verify($password, $user['password_hash'])) {
            $error = 'Credenciales inválidas.';
            view('auth/login', compact('error', 'email'));
            return;
        }
        Session::login($user);
        redirect('/');
    }

    public function logout(): void
    {
        Session::logout();
        redirect('/login');
    }
}
