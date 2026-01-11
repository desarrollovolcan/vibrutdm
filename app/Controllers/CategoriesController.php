<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Session;
use App\Models\Category;
use App\Models\Tournament;

class CategoriesController
{
    public function index(): void
    {
        $categories = (new Category())->all();
        view('categories/index', compact('categories'));
    }

    public function create(): void
    {
        $tournaments = (new Tournament())->all();
        view('categories/create', compact('tournaments'));
    }

    public function store(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $data = [
            'tournament_id' => (int)($_POST['tournament_id'] ?? 0),
            'name' => trim($_POST['name'] ?? ''),
            'group_size' => (int)($_POST['group_size'] ?? 3),
            'qualify_per_group' => (int)($_POST['qualify_per_group'] ?? 2),
            'best_of_sets' => (int)($_POST['best_of_sets'] ?? 5),
            'points_per_set' => (int)($_POST['points_per_set'] ?? 11),
            'bracket_size' => (int)($_POST['bracket_size'] ?? 8),
            'tiebreak_criteria' => $_POST['tiebreak_criteria'] ?? 'matches_won,sets_ratio,points_ratio,head_to_head',
        ];
        (new Category())->create($data);
        redirect('/categories');
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $category = (new Category())->find($id);
        $tournaments = (new Tournament())->all();
        view('categories/edit', compact('category', 'tournaments'));
    }

    public function update(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'tournament_id' => (int)($_POST['tournament_id'] ?? 0),
            'name' => trim($_POST['name'] ?? ''),
            'group_size' => (int)($_POST['group_size'] ?? 3),
            'qualify_per_group' => (int)($_POST['qualify_per_group'] ?? 2),
            'best_of_sets' => (int)($_POST['best_of_sets'] ?? 5),
            'points_per_set' => (int)($_POST['points_per_set'] ?? 11),
            'bracket_size' => (int)($_POST['bracket_size'] ?? 8),
            'tiebreak_criteria' => $_POST['tiebreak_criteria'] ?? 'matches_won,sets_ratio,points_ratio,head_to_head',
        ];
        (new Category())->update($id, $data);
        redirect('/categories');
    }

    public function delete(): void
    {
        if (!Session::validateToken($_POST['_token'] ?? null)) {
            http_response_code(419);
            view('errors/419');
            return;
        }
        $id = (int)($_POST['id'] ?? 0);
        (new Category())->delete($id);
        redirect('/categories');
    }
}
