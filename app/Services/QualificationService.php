<?php

namespace App\Services;

use App\Models\BracketModel;
use App\Models\BracketSlotModel;
use App\Models\CategoryModel;
use App\Models\GroupModel;
use App\Models\GroupStandingModel;

class QualificationService
{
    public function generate(int $categoryId): array
    {
        $categoryModel = new CategoryModel();
        $groupModel = new GroupModel();
        $standingModel = new GroupStandingModel();
        $bracketModel = new BracketModel();
        $bracketSlotModel = new BracketSlotModel();

        $category = $categoryModel->find($categoryId);
        if (!$category) {
            throw new \RuntimeException('Categoría no encontrada.');
        }

        $groups = $groupModel->listByCategory($categoryId);
        $candidates = [];

        foreach ($groups as $group) {
            $topPlayers = $standingModel->topNByGroup((int) $group['id'], (int) $category['qualify_per_group']);
            foreach ($topPlayers as $player) {
                $candidates[] = $player['player_id'];
            }
        }

        $bracketSize = (int) $category['bracket_size'];
        $bracketId = $bracketModel->create($categoryId, $bracketSize);

        for ($i = 1; $i <= $bracketSize; $i++) {
            $playerId = $candidates[$i - 1] ?? null;
            $bracketSlotModel->create([
                'bracket_id' => $bracketId,
                'slot_no' => $i,
                'seed' => $i,
                'player_id' => $playerId,
            ]);
        }

        return [
            'bracket_id' => $bracketId,
            'players' => $candidates,
        ];
    }
}
