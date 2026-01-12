<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CategoryModel;
use App\Models\PlayerModel;
use App\Models\RegistrationModel;

class RegistrationController extends Controller
{
    public function index(): void
    {
        $categoryId = (int) ($_GET['category_id'] ?? 0);
        $registrationModel = new RegistrationModel();
        $playerModel = new PlayerModel();
        $categoryModel = new CategoryModel();

        $this->view('registrations/index', [
            'category' => $categoryModel->find($categoryId),
            'registrations' => $categoryId ? $registrationModel->listByCategory($categoryId) : [],
            'players' => $playerModel->all(),
        ]);
    }

    public function store(): void
    {
        $categoryId = (int) ($_POST['category_id'] ?? 0);
        $playerId = (int) ($_POST['player_id'] ?? 0);
        $rankingSeed = $_POST['ranking_seed'] !== '' ? (int) $_POST['ranking_seed'] : null;

        $registrationModel = new RegistrationModel();
        $registrationModel->create($categoryId, $playerId, $rankingSeed);

        $this->redirect('/registrations?category_id=' . $categoryId);
    }

    public function delete(): void
    {
        $categoryId = (int) ($_POST['category_id'] ?? 0);
        $playerId = (int) ($_POST['player_id'] ?? 0);

        $registrationModel = new RegistrationModel();
        $registrationModel->delete($categoryId, $playerId);

        $this->redirect('/registrations?category_id=' . $categoryId);
    }
}
