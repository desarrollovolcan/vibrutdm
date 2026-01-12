<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\MatchModel;
use App\Models\MatchSetModel;
use App\Services\ResultService;
use App\Services\StandingsService;
use App\Services\BracketService;

class ResultController extends Controller
{
    public function editMatch(): void
    {
        $matchId = (int) ($_GET['match_id'] ?? 0);
        $matchModel = new MatchModel();
        $matchSetModel = new MatchSetModel();

        if ($matchId === 0) {
            $match = $matchModel->first();
            if ($match) {
                $this->redirect('/results/edit?match_id=' . $match['id']);
                return;
            }
        }

        $this->view('results/edit', [
            'match' => $matchModel->find($matchId),
            'sets' => $matchSetModel->listByMatch($matchId),
        ]);
    }

    public function updateMatch(): void
    {
        $matchId = (int) ($_POST['match_id'] ?? 0);
        $sets = $_POST['sets'] ?? [];
        $userId = (int) ($_SESSION['user']['id'] ?? 0);

        $resultService = new ResultService();
        $resultService->saveSets($matchId, $sets, $userId);

        $matchModel = new MatchModel();
        $match = $matchModel->find($matchId);

        if ($match && $match['phase'] === 'group') {
            $standings = new StandingsService();
            $standings->recalculateGroup((int) $match['group_id']);
        }

        if ($match && $match['phase'] === 'bracket') {
            $bracketService = new BracketService();
            $bracketService->propagateWinner($matchId);
        }

        $this->redirect('/results/edit?match_id=' . $matchId);
    }
}
