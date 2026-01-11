<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\GroupPlayer;
use App\Models\GroupStanding;
use App\Models\MatchModel;
use App\Models\MatchSet;

class StandingsService
{
    public function recalcGroup(int $groupId): array
    {
        $groupPlayerModel = new GroupPlayer();
        $matchModel = new MatchModel();
        $setModel = new MatchSet();
        $standingModel = new GroupStanding();

        $players = $groupPlayerModel->allByGroup($groupId);
        $stats = [];
        foreach ($players as $player) {
            $stats[$player['player_id']] = [
                'player_id' => (int)$player['player_id'],
                'matches_played' => 0,
                'matches_won' => 0,
                'matches_lost' => 0,
                'sets_won' => 0,
                'sets_lost' => 0,
                'points_for' => 0,
                'points_against' => 0,
            ];
        }

        $matches = $matchModel->allByGroup($groupId);
        foreach ($matches as $match) {
            if ($match['status'] !== 'completed') {
                continue;
            }
            $sets = $setModel->allByMatch((int)$match['id']);
            $playerA = (int)$match['player_a_id'];
            $playerB = (int)$match['player_b_id'];
            if (!isset($stats[$playerA], $stats[$playerB])) {
                continue;
            }
            $stats[$playerA]['matches_played']++;
            $stats[$playerB]['matches_played']++;
            if ((int)$match['winner_id'] === $playerA) {
                $stats[$playerA]['matches_won']++;
                $stats[$playerB]['matches_lost']++;
            } elseif ((int)$match['winner_id'] === $playerB) {
                $stats[$playerB]['matches_won']++;
                $stats[$playerA]['matches_lost']++;
            }
            foreach ($sets as $set) {
                if ($set['points_a'] > $set['points_b']) {
                    $stats[$playerA]['sets_won']++;
                    $stats[$playerB]['sets_lost']++;
                } elseif ($set['points_b'] > $set['points_a']) {
                    $stats[$playerB]['sets_won']++;
                    $stats[$playerA]['sets_lost']++;
                }
                $stats[$playerA]['points_for'] += (int)$set['points_a'];
                $stats[$playerA]['points_against'] += (int)$set['points_b'];
                $stats[$playerB]['points_for'] += (int)$set['points_b'];
                $stats[$playerB]['points_against'] += (int)$set['points_a'];
            }
        }

        $rows = array_values($stats);
        usort($rows, function ($a, $b) use ($groupId, $matchModel) {
            if ($a['matches_won'] !== $b['matches_won']) {
                return $b['matches_won'] <=> $a['matches_won'];
            }
            $ratioA = $this->ratio($a['sets_won'], $a['sets_lost']);
            $ratioB = $this->ratio($b['sets_won'], $b['sets_lost']);
            if ($ratioA !== $ratioB) {
                return $ratioB <=> $ratioA;
            }
            $pointsRatioA = $this->ratio($a['points_for'], $a['points_against']);
            $pointsRatioB = $this->ratio($b['points_for'], $b['points_against']);
            if ($pointsRatioA !== $pointsRatioB) {
                return $pointsRatioB <=> $pointsRatioA;
            }
            $head = $this->headToHead($groupId, (int)$a['player_id'], (int)$b['player_id'], $matchModel);
            if ($head !== 0) {
                return $head;
            }
            return 0;
        });

        $rank = 1;
        foreach ($rows as &$row) {
            $row['rank_pos'] = $rank++;
        }

        $standingModel->replace($groupId, $rows);
        return $rows;
    }

    private function ratio(int $won, int $lost): float
    {
        return $lost === 0 ? (float)$won : $won / $lost;
    }

    private function headToHead(int $groupId, int $playerA, int $playerB, MatchModel $matchModel): int
    {
        $matches = $matchModel->allByGroup($groupId);
        foreach ($matches as $match) {
            if ($match['status'] !== 'completed') {
                continue;
            }
            $ids = [(int)$match['player_a_id'], (int)$match['player_b_id']];
            if (in_array($playerA, $ids, true) && in_array($playerB, $ids, true)) {
                if ((int)$match['winner_id'] === $playerA) {
                    return -1;
                }
                if ((int)$match['winner_id'] === $playerB) {
                    return 1;
                }
            }
        }
        return 0;
    }
}
