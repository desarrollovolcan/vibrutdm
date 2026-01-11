<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Session;
use App\Models\Category;
use App\Models\Player;
use App\Models\Registration;

class RegistrationsController
{
    public function index(): void
    {
        $categories = (new Category())->all();
        $categoryId = (int)($_GET['category_id'] ?? 0);
        $registrations = [];
        $players = [];
        if ($categoryId) {
            $registrations = (new Registration())->allByCategory($categoryId);
            $players = (new Player())->all();
        }
        view('registrations/index', compact('categories', 'categoryId', 'registrations', 'players'));
    }

    public function store(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $data = [
            'category_id' => (int)($_POST['category_id'] ?? 0),
            'player_id' => (int)($_POST['player_id'] ?? 0),
            'ranking_seed' => $_POST['ranking_seed'] ?? null,
        ];
        (new Registration())->create($data);
        redirect('/registrations?category_id=' . $data['category_id']);
    }

    public function delete(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $categoryId = (int)($_POST['category_id'] ?? 0);
        $playerId = (int)($_POST['player_id'] ?? 0);
        (new Registration())->delete($categoryId, $playerId);
        redirect('/registrations?category_id=' . $categoryId);
    }

    public function importCsv(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $categoryId = (int)($_POST['category_id'] ?? 0);
        if (!isset($_FILES['csv']) || $_FILES['csv']['error'] !== UPLOAD_ERR_OK) {
            redirect('/registrations?category_id=' . $categoryId);
        }
        $file = fopen($_FILES['csv']['tmp_name'], 'r');
        if ($file === false) {
            redirect('/registrations?category_id=' . $categoryId);
        }
        $registrationModel = new Registration();
        while (($row = fgetcsv($file)) !== false) {
            $playerId = (int)($row[0] ?? 0);
            $seed = $row[1] ?? null;
            if ($playerId) {
                $registrationModel->create([
                    'category_id' => $categoryId,
                    'player_id' => $playerId,
                    'ranking_seed' => $seed,
                ]);
            }
        }
        fclose($file);
        redirect('/registrations?category_id=' . $categoryId);
    }
}
