<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\MatchModel;

class MatchSchedulerService
{
    public function createRoundRobin(int $categoryId, int $groupId, array $playerIds, int $bestOfSets): void
    {
        $matchModel = new MatchModel();
        $total = count($playerIds);
        for ($i = 0; $i < $total; $i++) {
            for ($j = $i + 1; $j < $total; $j++) {
                $matchModel->create([
                    'phase' => 'groups',
                    'category_id' => $categoryId,
                    'group_id' => $groupId,
                    'bracket_id' => null,
                    'round_number' => 1,
                    'match_number' => null,
                    'player_a_id' => $playerIds[$i],
                    'player_b_id' => $playerIds[$j],
                    'status' => 'scheduled',
                    'winner_id' => null,
                    'best_of_sets' => $bestOfSets,
                ]);
            }
        }
    }

    public function createBracketRound(int $categoryId, int $bracketId, int $roundNumber, array $pairs, int $bestOfSets): void
    {
        $matchModel = new MatchModel();
        $matchNumber = 1;
        foreach ($pairs as $pair) {
            $matchModel->create([
                'phase' => 'bracket',
                'category_id' => $categoryId,
                'group_id' => null,
                'bracket_id' => $bracketId,
                'round_number' => $roundNumber,
                'match_number' => $matchNumber++,
                'player_a_id' => $pair['player_a_id'],
                'player_b_id' => $pair['player_b_id'],
                'status' => $pair['status'],
                'winner_id' => $pair['winner_id'],
                'best_of_sets' => $bestOfSets,
            ]);
        }
    }
}
