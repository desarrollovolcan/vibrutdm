<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Session;
use App\Models\MatchModel;
use App\Models\MatchSet;
use App\Services\ResultService;
use App\Services\BracketService;

class MatchesController
{
    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $match = (new MatchModel())->findWithNames($id);
        $sets = (new MatchSet())->allByMatch($id);
        view('matches/edit', compact('match', 'sets'));
    }

    public function update(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $matchId = (int)($_POST['match_id'] ?? 0);
        $sets = $_POST['sets'] ?? [];
        $user = Session::user();
        if ($user) {
            (new ResultService())->saveMatchResult($matchId, $sets, (int)$user['id']);
            (new BracketService())->advanceWinner($matchId);
        }
        redirect($_POST['redirect_to'] ?? '/');
    }
}
