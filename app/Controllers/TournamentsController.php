<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Session;
use App\Models\Tournament;

class TournamentsController
{
    public function index(): void
    {
        $tournaments = (new Tournament())->all();
        view('tournaments/index', compact('tournaments'));
    }

    public function create(): void
    {
        view('tournaments/create');
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
            'venue' => trim($_POST['venue'] ?? ''),
            'date_start' => $_POST['date_start'] ?? date('Y-m-d'),
            'status' => $_POST['status'] ?? 'borrador',
        ];
        (new Tournament())->create($data);
        redirect('/tournaments');
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $tournament = (new Tournament())->find($id);
        view('tournaments/edit', compact('tournament'));
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
            'venue' => trim($_POST['venue'] ?? ''),
            'date_start' => $_POST['date_start'] ?? date('Y-m-d'),
            'status' => $_POST['status'] ?? 'borrador',
        ];
        (new Tournament())->update($id, $data);
        redirect('/tournaments');
    }

    public function delete(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $id = (int)($_POST['id'] ?? 0);
        (new Tournament())->delete($id);
        redirect('/tournaments');
    }
}
