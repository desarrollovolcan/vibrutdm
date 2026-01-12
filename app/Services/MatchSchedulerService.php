<?php

namespace App\Services;

use App\Models\GroupPlayerModel;
use App\Models\MatchModel;

class MatchSchedulerService
{
    public function createRoundRobinMatches(int $groupId, int $bestOfSets, int $categoryId): array
    {
        $groupPlayerModel = new GroupPlayerModel();
        $matchModel = new MatchModel();

        $players = $groupPlayerModel->listByGroup($groupId);
        $matches = [];

        $count = count($players);
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                $matchId = $matchModel->create([
                    'category_id' => $categoryId,
                    'phase' => 'group',
                    'group_id' => $groupId,
                    'bracket_id' => null,
                    'round_number' => null,
                    'match_index' => null,
                    'player_a_id' => $players[$i]['player_id'],
                    'player_b_id' => $players[$j]['player_id'],
                    'best_of_sets' => $bestOfSets,
                    'status' => 'pending',
                ]);
                $matches[] = $matchId;
            }
        }

        return $matches;
    }
}
