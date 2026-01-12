<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AssociationModel;
use App\Models\PlayerModel;

class PlayerController extends Controller
{
    public function index(): void
    {
        $playerModel = new PlayerModel();
        $associationModel = new AssociationModel();

        $this->view('players/index', [
            'players' => $playerModel->all(),
            'associations' => $associationModel->all(),
        ]);
    }

    public function store(): void
    {
        $playerModel = new PlayerModel();
        $playerModel->create([
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'association_id' => (int) ($_POST['association_id'] ?? 0),
            'ranking_points' => (int) ($_POST['ranking_points'] ?? 0),
        ]);

        $this->redirect('/players');
    }
}
