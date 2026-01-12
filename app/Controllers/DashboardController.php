<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\TournamentModel;

class DashboardController extends Controller
{
    public function index(): void
    {
        $tournamentModel = new TournamentModel();
        $tournaments = $tournamentModel->all();

        $this->view('dashboard/index', [
            'tournaments' => $tournaments,
        ]);
    }
}
