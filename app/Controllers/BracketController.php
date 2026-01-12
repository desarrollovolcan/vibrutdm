<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\BracketModel;
use App\Models\MatchModel;

class BracketController extends Controller
{
    public function show(): void
    {
        $categoryId = (int) ($_GET['category_id'] ?? 0);
        $bracketModel = new BracketModel();
        $matchModel = new MatchModel();
        $bracket = $bracketModel->findByCategory($categoryId);

        $this->view('brackets/show', [
            'bracket' => $bracket,
            'matches' => $bracket ? $matchModel->listByBracket((int) $bracket['id']) : [],
        ]);
    }
}
