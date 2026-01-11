<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Tournament;
use App\Models\MatchModel;

class DashboardController
{
    public function index(): void
    {
        $tournamentModel = new Tournament();
        $matchModel = new MatchModel();
        $tournaments = $tournamentModel->all();
        $upcomingMatches = $matchModel->latest(6);
        view('dashboard/index', compact('tournaments', 'upcomingMatches'));
    }
}
