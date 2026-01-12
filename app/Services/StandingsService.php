<?php

namespace App\Services;

use App\Models\GroupPlayerModel;
use App\Models\GroupStandingModel;
use App\Models\MatchModel;
use App\Models\MatchSetModel;

class StandingsService
{
    public function recalculateGroup(int $groupId): void
    {
        $groupPlayerModel = new GroupPlayerModel();
        $matchModel = new MatchModel();
        $matchSetModel = new MatchSetModel();
        $groupStandingModel = new GroupStandingModel();

        $players = $groupPlayerModel->listByGroup($groupId);
        $stats = [];

        foreach ($players as $player) {
            $playerId = (int) $player['player_id'];
            $stats[$playerId] = [
                'group_id' => $groupId,
                'player_id' => $playerId,
                'matches_won' => 0,
                'matches_lost' => 0,
                'sets_won' => 0,
                'sets_lost' => 0,
                'points_for' => 0,
                'points_against' => 0,
                'rank_pos' => 0,
            ];
        }

        $matches = $matchModel->listFinishedByGroup($groupId);
        foreach ($matches as $match) {
            $sets = $matchSetModel->listByMatch((int) $match['id']);
            $playerA = (int) $match['player_a_id'];
            $playerB = (int) $match['player_b_id'];

            if ((int) $match['winner_id'] === $playerA) {
                $stats[$playerA]['matches_won']++;
                $stats[$playerB]['matches_lost']++;
            } elseif ((int) $match['winner_id'] === $playerB) {
                $stats[$playerB]['matches_won']++;
                $stats[$playerA]['matches_lost']++;
            }

            foreach ($sets as $set) {
                $pointsA = (int) $set['points_a'];
                $pointsB = (int) $set['points_b'];
                $stats[$playerA]['points_for'] += $pointsA;
                $stats[$playerA]['points_against'] += $pointsB;
                $stats[$playerB]['points_for'] += $pointsB;
                $stats[$playerB]['points_against'] += $pointsA;

                if ($pointsA > $pointsB) {
                    $stats[$playerA]['sets_won']++;
                    $stats[$playerB]['sets_lost']++;
                } elseif ($pointsB > $pointsA) {
                    $stats[$playerB]['sets_won']++;
                    $stats[$playerA]['sets_lost']++;
                }
            }
        }

        $sorted = array_values($stats);
        usort($sorted, function (array $a, array $b) {
            if ($a['matches_won'] !== $b['matches_won']) {
                return $b['matches_won'] <=> $a['matches_won'];
            }

            $ratioSetsA = $a['sets_won'] / max(1, $a['sets_lost']);
            $ratioSetsB = $b['sets_won'] / max(1, $b['sets_lost']);
            if ($ratioSetsA !== $ratioSetsB) {
                return $ratioSetsB <=> $ratioSetsA;
            }

            $ratioPointsA = $a['points_for'] / max(1, $a['points_against']);
            $ratioPointsB = $b['points_for'] / max(1, $b['points_against']);
            return $ratioPointsB <=> $ratioPointsA;
        });

        $rank = 1;
        foreach ($sorted as $entry) {
            $entry['rank_pos'] = $rank++;
            $groupStandingModel->upsert($entry);
        }
    }
}
