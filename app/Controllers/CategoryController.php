<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CategoryModel;
use App\Models\TournamentModel;

class CategoryController extends Controller
{
    public function index(): void
    {
        $tournamentId = (int) ($_GET['tournament_id'] ?? 0);
        $model = new CategoryModel();
        if ($tournamentId === 0) {
            $tournamentModel = new TournamentModel();
            $tournament = $tournamentModel->first();

            if ($tournament) {
                $this->redirect('/categories?tournament_id=' . $tournament['id']);
                return;
            }
        }

        $categories = $tournamentId ? $model->listByTournament($tournamentId) : [];

        $this->view('categories/index', [
            'categories' => $categories,
            'tournamentId' => $tournamentId,
        ]);
    }

    public function create(): void
    {
        $tournamentId = (int) ($_GET['tournament_id'] ?? 0);
        $this->view('categories/create', ['tournamentId' => $tournamentId]);
    }

    public function store(): void
    {
        $model = new CategoryModel();
        $model->create([
            'tournament_id' => (int) ($_POST['tournament_id'] ?? 0),
            'name' => $_POST['name'] ?? '',
            'players_per_group' => (int) ($_POST['players_per_group'] ?? 4),
            'qualify_per_group' => (int) ($_POST['qualify_per_group'] ?? 2),
            'best_of_sets' => (int) ($_POST['best_of_sets'] ?? 5),
            'bracket_size' => (int) ($_POST['bracket_size'] ?? 16),
        ]);

        $this->redirect('/categories?tournament_id=' . ($_POST['tournament_id'] ?? 0));
    }
}
