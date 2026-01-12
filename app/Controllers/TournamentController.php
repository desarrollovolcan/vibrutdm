<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\TournamentModel;

class TournamentController extends Controller
{
    public function index(): void
    {
        $model = new TournamentModel();
        $tournaments = $model->all();

        $this->view('tournaments/index', ['tournaments' => $tournaments]);
    }

    public function create(): void
    {
        $this->view('tournaments/create');
    }

    public function store(): void
    {
        $model = new TournamentModel();
        $model->create([
            'name' => $_POST['name'] ?? '',
            'location' => $_POST['location'] ?? '',
            'start_date' => $_POST['start_date'] ?? null,
            'end_date' => $_POST['end_date'] ?? null,
            'status' => $_POST['status'] ?? 'draft',
        ]);

        $this->redirect('/tournaments');
    }
}
