<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\GroupModel;
use App\Models\GroupPlayerModel;
use App\Models\MatchModel;
use App\Services\GroupGeneratorService;
use App\Services\MatchSchedulerService;
use App\Services\StandingsService;

class GroupController extends Controller
{
    public function index(): void
    {
        $categoryId = (int) ($_GET['category_id'] ?? 0);
        $groupModel = new GroupModel();

        $this->view('groups/index', [
            'groups' => $categoryId ? $groupModel->listByCategory($categoryId) : [],
            'categoryId' => $categoryId,
        ]);
    }

    public function generate(): void
    {
        $categoryId = (int) ($_POST['category_id'] ?? 0);
        $modo = $_POST['modo'] ?? 'snake';

        $service = new GroupGeneratorService();
        $groups = $service->generate($categoryId, $modo);

        $scheduler = new MatchSchedulerService();
        $categoryBestOf = (int) ($_POST['best_of_sets'] ?? 5);
        foreach ($groups as $groupId) {
            $scheduler->createRoundRobinMatches($groupId, $categoryBestOf, $categoryId);
        }

        $this->redirect('/groups?category_id=' . $categoryId);
    }

    public function show(): void
    {
        $groupId = (int) ($_GET['group_id'] ?? 0);
        $groupPlayerModel = new GroupPlayerModel();
        $matchModel = new MatchModel();

        $this->view('groups/show', [
            'players' => $groupPlayerModel->listByGroup($groupId),
            'matches' => $matchModel->listByGroup($groupId),
            'groupId' => $groupId,
        ]);
    }

    public function recalculate(): void
    {
        $groupId = (int) ($_POST['group_id'] ?? 0);
        $service = new StandingsService();
        $service->recalculateGroup($groupId);

        $this->redirect('/groups/show?group_id=' . $groupId);
    }
}
