<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\GroupModel;
use App\Models\MatchModel;

class MatchController extends Controller
{
    public function show(): void
    {
        $groupId = (int) ($_GET['group_id'] ?? 0);
        $groupModel = new GroupModel();
        $matchModel = new MatchModel();

        if ($groupId === 0) {
            $group = $groupModel->first();
            if ($group) {
                $this->redirect('/matches?group_id=' . $group['id']);
                return;
            }
        }

        $this->view('matches/show', [
            'matches' => $groupId ? $matchModel->listByGroup($groupId) : [],
            'groupId' => $groupId,
        ]);
    }
}
