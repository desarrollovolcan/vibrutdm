<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Session;
use App\Models\User;

class UsersController
{
    public function index(): void
    {
        $users = (new User())->all();
        view('users/index', compact('users'));
    }

    public function create(): void
    {
        view('users/create');
    }

    public function store(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'role' => $_POST['role'] ?? 'LECTURA',
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'password_hash' => password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT),
        ];
        (new User())->create($data);
        redirect('/users');
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $user = (new User())->find($id);
        view('users/edit', compact('user'));
    }

    public function update(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'role' => $_POST['role'] ?? 'LECTURA',
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        $userModel = new User();
        $userModel->update($id, $data);
        if (!empty($_POST['password'])) {
            $userModel->updatePassword($id, password_hash($_POST['password'], PASSWORD_DEFAULT));
        }
        redirect('/users');
    }

    public function delete(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $id = (int)($_POST['id'] ?? 0);
        (new User())->delete($id);
        redirect('/users');
    }
}
