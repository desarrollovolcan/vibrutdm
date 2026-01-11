<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Session;
use App\Models\Category;
use App\Models\GroupModel;
use App\Models\GroupPlayer;
use App\Models\MatchModel;
use App\Models\GroupStanding;
use App\Services\GroupGeneratorService;
use App\Services\MatchSchedulerService;
use App\Services\StandingsService;

class GroupsController
{
    public function index(): void
    {
        $categories = (new Category())->all();
        $categoryId = (int)($_GET['category_id'] ?? 0);
        $groups = [];
        if ($categoryId) {
            $groups = (new GroupModel())->allByCategory($categoryId);
        }
        view('groups/index', compact('categories', 'categoryId', 'groups'));
    }

    public function generate(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $categoryId = (int)($_POST['category_id'] ?? 0);
        $avoid = isset($_POST['avoid_same_association']);
        $category = (new Category())->find($categoryId);
        if (!$category) {
            redirect('/groups');
        }
        $generator = new GroupGeneratorService();
        $result = $generator->generate($categoryId, (int)$category['group_size'], $avoid);

        $groupModel = new GroupModel();
        $groupPlayerModel = new GroupPlayer();
        $matchModel = new MatchModel();
        $matchModel->clearByCategoryPhase($categoryId, 'groups');
        $scheduler = new MatchSchedulerService();

        foreach ($groupModel->allByCategory($categoryId) as $group) {
            $players = $groupPlayerModel->allByGroup((int)$group['id']);
            $playerIds = array_map(fn($p) => (int)$p['player_id'], $players);
            if (count($playerIds) >= 2) {
                $scheduler->createRoundRobin($categoryId, (int)$group['id'], $playerIds, (int)$category['best_of_sets']);
            }
        }

        $message = $result['message'] ?? 'Grupos generados.';
        view('groups/generate_result', compact('message', 'categoryId'));
    }

    public function show(): void
    {
        $groupId = (int)($_GET['id'] ?? 0);
        $groupModel = new GroupModel();
        $group = null;
        foreach ($groupModel->allByCategory((int)($_GET['category_id'] ?? 0)) as $g) {
            if ((int)$g['id'] === $groupId) {
                $group = $g;
                break;
            }
        }
        $players = (new GroupPlayer())->allByGroup($groupId);
        $matches = (new MatchModel())->allByGroup($groupId);
        $standings = (new GroupStanding())->allByGroup($groupId);
        view('groups/show', compact('group', 'players', 'matches', 'standings'));
    }

    public function recalc(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $groupId = (int)($_POST['group_id'] ?? 0);
        (new StandingsService())->recalcGroup($groupId);
        redirect('/groups/show?id=' . $groupId . '&category_id=' . (int)($_POST['category_id'] ?? 0));
    }
}
