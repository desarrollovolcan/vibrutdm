<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\MatchModel;

class MatchController extends Controller
{
    public function show(): void
    {
        $groupId = (int) ($_GET['group_id'] ?? 0);
        $matchModel = new MatchModel();

        $this->view('matches/show', [
            'matches' => $groupId ? $matchModel->listByGroup($groupId) : [],
            'groupId' => $groupId,
        ]);
    }
}
