<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Session;
use App\Models\Association;

class AssociationsController
{
    public function index(): void
    {
        $associations = (new Association())->all();
        view('associations/index', compact('associations'));
    }

    public function create(): void
    {
        view('associations/create');
    }

    public function store(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        (new Association())->create(['name' => trim($_POST['name'] ?? '')]);
        redirect('/associations');
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $association = (new Association())->find($id);
        view('associations/edit', compact('association'));
    }

    public function update(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $id = (int)($_POST['id'] ?? 0);
        (new Association())->update($id, ['name' => trim($_POST['name'] ?? '')]);
        redirect('/associations');
    }

    public function delete(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $id = (int)($_POST['id'] ?? 0);
        (new Association())->delete($id);
        redirect('/associations');
    }
}
