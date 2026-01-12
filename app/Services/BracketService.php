<?php

namespace App\Services;

use App\Models\BracketModel;
use App\Models\BracketSlotModel;
use App\Models\CategoryModel;
use App\Models\MatchModel;

class BracketService
{
    public function generate(int $categoryId, array $qualifiedPlayers): int
    {
        $categoryModel = new CategoryModel();
        $bracketModel = new BracketModel();
        $bracketSlotModel = new BracketSlotModel();

        $category = $categoryModel->find($categoryId);
        if (!$category) {
            throw new \RuntimeException('Categoría no encontrada.');
        }

        $size = (int) $category['bracket_size'];
        $bracketId = $bracketModel->create($categoryId, $size);

        $order = $this->seedOrder($size);
        foreach ($order as $index => $seed) {
            $playerId = $qualifiedPlayers[$seed - 1] ?? null;
            $bracketSlotModel->create([
                'bracket_id' => $bracketId,
                'slot_no' => $index + 1,
                'seed' => $seed,
                'player_id' => $playerId,
            ]);
        }

        $this->createBracketMatches($bracketId, $size, (int) $category['best_of_sets'], $categoryId);

        return $bracketId;
    }

    public function seedOrder(int $size): array
    {
        if ($size === 2) {
            return [1, 2];
        }

        $previous = $this->seedOrder((int) ($size / 2));
        $mirror = array_map(fn ($seed) => $size + 1 - $seed, $previous);

        $order = [];
        foreach ($previous as $index => $seed) {
            $order[] = $seed;
            $order[] = $mirror[$index];
        }

        return $order;
    }

    public function createBracketMatches(int $bracketId, int $size, int $bestOfSets, int $categoryId): void
    {
        $bracketSlotModel = new BracketSlotModel();
        $matchModel = new MatchModel();

        $slots = $bracketSlotModel->listByBracket($bracketId);
        $rounds = (int) log($size, 2);

        $slotIndex = 0;
        for ($round = 1; $round <= $rounds; $round++) {
            $matchesInRound = (int) ($size / pow(2, $round));
            for ($matchIndex = 1; $matchIndex <= $matchesInRound; $matchIndex++) {
                $playerA = null;
                $playerB = null;

                if ($round === 1) {
                    $playerA = $slots[$slotIndex]['player_id'] ?? null;
                    $playerB = $slots[$slotIndex + 1]['player_id'] ?? null;
                    $slotIndex += 2;
                }

                $matchId = $matchModel->create([
                    'category_id' => $categoryId,
                    'phase' => 'bracket',
                    'group_id' => null,
                    'bracket_id' => $bracketId,
                    'round_number' => $round,
                    'match_index' => $matchIndex,
                    'player_a_id' => $playerA,
                    'player_b_id' => $playerB,
                    'best_of_sets' => $bestOfSets,
                    'status' => 'pending',
                ]);

                if ($round === 1 && ($playerA xor $playerB)) {
                    $winner = $playerA ?: $playerB;
                    $matchModel->update($matchId, [
                        'status' => 'finished',
                        'winner_id' => $winner,
                        'player_a_id' => $playerA,
                        'player_b_id' => $playerB,
                    ]);
                    $this->propagateWinner($matchId);
                }
            }
        }
    }

    public function propagateWinner(int $matchId): void
    {
        $matchModel = new MatchModel();
        $match = $matchModel->find($matchId);

        if (!$match || !$match['winner_id']) {
            return;
        }

        $round = (int) $match['round_number'];
        $index = (int) $match['match_index'];
        $nextRound = $round + 1;
        $parentIndex = (int) ceil($index / 2);

        $parent = $matchModel->findByBracketRoundIndex((int) $match['bracket_id'], $nextRound, $parentIndex);

        if (!$parent) {
            return;
        }

        $data = [
            'status' => $parent['status'],
            'winner_id' => $parent['winner_id'],
            'player_a_id' => $parent['player_a_id'],
            'player_b_id' => $parent['player_b_id'],
        ];

        if ($index % 2 === 1) {
            $data['player_a_id'] = $match['winner_id'];
        } else {
            $data['player_b_id'] = $match['winner_id'];
        }

        $matchModel->update((int) $parent['id'], $data);
    }
}
