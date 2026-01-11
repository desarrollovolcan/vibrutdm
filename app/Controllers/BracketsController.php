<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Session;
use App\Models\Bracket;
use App\Models\BracketSlot;
use App\Models\Category;
use App\Models\GroupModel;
use App\Models\MatchModel;
use App\Services\BracketService;
use App\Services\QualificationService;
use App\Services\StandingsService;

class BracketsController
{
    public function index(): void
    {
        $categories = (new Category())->all();
        $categoryId = (int)($_GET['category_id'] ?? 0);
        if ($categoryId) {
            redirect('/brackets/show?category_id=' . $categoryId);
        }
        view('brackets/index', compact('categories'));
    }

    public function show(): void
    {
        $categoryId = (int)($_GET['category_id'] ?? 0);
        $category = (new Category())->find($categoryId);
        $bracket = (new Bracket())->findByCategory($categoryId);
        $slots = [];
        $matchesByRound = [];
        if ($bracket) {
            $slots = (new BracketSlot())->allByBracket((int)$bracket['id']);
            $matches = (new MatchModel())->allByCategoryPhase($categoryId, 'bracket');
            foreach ($matches as $match) {
                $matchesByRound[$match['round_number']][] = $match;
            }
        }
        view('brackets/show', compact('category', 'bracket', 'slots', 'matchesByRound'));
    }

    public function generate(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $categoryId = (int)($_POST['category_id'] ?? 0);
        $category = (new Category())->find($categoryId);
        if (!$category) {
            redirect('/brackets');
        }

        $groupModel = new GroupModel();
        $standingsService = new StandingsService();
        foreach ($groupModel->allByCategory($categoryId) as $group) {
            $standingsService->recalcGroup((int)$group['id']);
        }

        $qualifiers = (new QualificationService())->selectQualified(
            $categoryId,
            (int)$category['qualify_per_group'],
            (int)$category['bracket_size']
        );

        $bracketService = new BracketService();
        $bracketId = $bracketService->generateBracket(
            $categoryId,
            $qualifiers,
            (int)$category['bracket_size'],
            (int)$category['best_of_sets']
        );
        $bracketService->createNextRounds(
            $categoryId,
            $bracketId,
            (int)$category['bracket_size'],
            (int)$category['best_of_sets']
        );
        $bracketService->propagateByes($bracketId);

        redirect('/brackets/show?category_id=' . $categoryId);
    }
}
