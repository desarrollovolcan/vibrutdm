<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Session;
use App\Models\Association;
use App\Models\Player;

class PlayersController
{
    public function index(): void
    {
        $players = (new Player())->all();
        view('players/index', compact('players'));
    }

    public function create(): void
    {
        $associations = (new Association())->all();
        view('players/create', compact('associations'));
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
            'association_id' => $_POST['association_id'] ?? null,
            'ranking_seed' => $_POST['ranking_seed'] ?? null,
        ];
        (new Player())->create($data);
        redirect('/players');
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $player = (new Player())->find($id);
        $associations = (new Association())->all();
        view('players/edit', compact('player', 'associations'));
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
            'association_id' => $_POST['association_id'] ?? null,
            'ranking_seed' => $_POST['ranking_seed'] ?? null,
        ];
        (new Player())->update($id, $data);
        redirect('/players');
    }

    public function delete(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $id = (int)($_POST['id'] ?? 0);
        (new Player())->delete($id);
        redirect('/players');
    }
}
