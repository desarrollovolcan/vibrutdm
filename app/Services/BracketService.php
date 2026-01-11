<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Bracket;
use App\Models\BracketSlot;
use App\Models\MatchModel;

class BracketService
{
    public function generateBracket(int $categoryId, array $qualified, int $size, int $bestOfSets): int
    {
        $bracketModel = new Bracket();
        $slotModel = new BracketSlot();
        $matchModel = new MatchModel();
        $scheduler = new MatchSchedulerService();

        $bracketModel->deleteByCategory($categoryId);
        $matchModel->clearByCategoryPhase($categoryId, 'bracket');

        $bracketId = $bracketModel->create($categoryId, $size);
        $slotModel->clearByBracket($bracketId);

        $seeds = $this->orderQualified($qualified);
        $order = $this->seedingOrder($size);
        $slots = array_fill(1, $size, null);

        for ($i = 0; $i < $size; $i++) {
            $slotNumber = $order[$i];
            $player = $seeds[$i] ?? null;
            $slots[$slotNumber] = $player;
            $slotModel->create([
                'bracket_id' => $bracketId,
                'slot_number' => $slotNumber,
                'player_id' => $player ? (int)$player['player_id'] : null,
                'source_type' => $player ? 'group_rank' : 'bye',
                'source_group_id' => $player['group_id'] ?? null,
                'source_rank' => $player['rank_pos'] ?? null,
            ]);
        }

        $pairs = [];
        for ($i = 1; $i <= $size; $i += 2) {
            $playerA = $slots[$i] ?? null;
            $playerB = $slots[$i + 1] ?? null;
            $status = 'scheduled';
            $winner = null;
            if ($playerA && !$playerB) {
                $status = 'walkover';
                $winner = (int)$playerA['player_id'];
            } elseif ($playerB && !$playerA) {
                $status = 'walkover';
                $winner = (int)$playerB['player_id'];
            }
            $pairs[] = [
                'player_a_id' => $playerA ? (int)$playerA['player_id'] : null,
                'player_b_id' => $playerB ? (int)$playerB['player_id'] : null,
                'status' => $status,
                'winner_id' => $winner,
            ];
        }

        $scheduler->createBracketRound($categoryId, $bracketId, 1, $pairs, $bestOfSets);
        return $bracketId;
    }

    public function advanceWinner(int $matchId): void
    {
        $matchModel = new MatchModel();
        $match = $matchModel->find($matchId);
        if (!$match || $match['phase'] !== 'bracket' || !$match['winner_id']) {
            return;
        }

        $round = (int)$match['round_number'];
        $nextRound = $round + 1;
        $matchNumber = (int)$match['match_number'];
        $nextMatchNumber = (int)ceil($matchNumber / 2);

        $nextMatch = $this->findBracketMatch($match['bracket_id'], $nextRound, $nextMatchNumber);
        if (!$nextMatch) {
            return;
        }

        $playerId = (int)$match['winner_id'];
        if ($matchNumber % 2 === 1) {
            $matchModel->updatePlayers((int)$nextMatch['id'], $playerId, $nextMatch['player_b_id']);
        } else {
            $matchModel->updatePlayers((int)$nextMatch['id'], $nextMatch['player_a_id'], $playerId);
        }
    }

    public function createNextRounds(int $categoryId, int $bracketId, int $size, int $bestOfSets): void
    {
        $scheduler = new MatchSchedulerService();
        $rounds = (int)log($size, 2);
        for ($round = 2; $round <= $rounds; $round++) {
            $matches = $size / (2 ** $round);
            $pairs = [];
            for ($i = 1; $i <= $matches; $i++) {
                $pairs[] = [
                    'player_a_id' => null,
                    'player_b_id' => null,
                    'status' => 'scheduled',
                    'winner_id' => null,
                ];
            }
            $scheduler->createBracketRound($categoryId, $bracketId, $round, $pairs, $bestOfSets);
        }
    }

    public function seedingOrder(int $size): array
    {
        if ($size <= 2) {
            return [1, 2];
        }
        $prev = $this->seedingOrder($size / 2);
        $result = [];
        foreach ($prev as $seed) {
            $result[] = $seed;
            $result[] = $size + 1 - $seed;
        }
        return $result;
    }

    private function orderQualified(array $qualified): array
    {
        usort($qualified, function ($a, $b) {
            if ($a['matches_won'] !== $b['matches_won']) {
                return $b['matches_won'] <=> $a['matches_won'];
            }
            $ratioA = $this->ratio((int)$a['sets_won'], (int)$a['sets_lost']);
            $ratioB = $this->ratio((int)$b['sets_won'], (int)$b['sets_lost']);
            if ($ratioA !== $ratioB) {
                return $ratioB <=> $ratioA;
            }
            $pointsRatioA = $this->ratio((int)$a['points_for'], (int)$a['points_against']);
            $pointsRatioB = $this->ratio((int)$b['points_for'], (int)$b['points_against']);
            if ($pointsRatioA !== $pointsRatioB) {
                return $pointsRatioB <=> $pointsRatioA;
            }
            return 0;
        });
        return $qualified;
    }

    private function ratio(int $won, int $lost): float
    {
        return $lost === 0 ? (float)$won : $won / $lost;
    }

    private function findBracketMatch(int $bracketId, int $round, int $matchNumber): ?array
    {
        $matchModel = new MatchModel();
        return $matchModel->findBracketMatch($bracketId, $round, $matchNumber);
    }

    private function propagateWalkovers(int $bracketId, int $round): void
    {
        $matchModel = new MatchModel();
        $matches = $matchModel->allByBracketRound($bracketId, $round);
        foreach ($matches as $match) {
            if ($match['status'] === 'walkover' && $match['winner_id']) {
                $this->advanceWinner((int)$match['id']);
            }
        }
    }

    public function propagateByes(int $bracketId): void
    {
        $this->propagateWalkovers($bracketId, 1);
    }
}
