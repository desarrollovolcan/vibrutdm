<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AuditLog;
use App\Models\MatchModel;
use App\Models\MatchSet;

class ResultService
{
    public function saveMatchResult(int $matchId, array $sets, int $userId): void
    {
        $matchModel = new MatchModel();
        $setModel = new MatchSet();
        $auditModel = new AuditLog();

        $match = $matchModel->find($matchId);
        if (!$match) {
            return;
        }

        $before = [
            'match' => $match,
            'sets' => $setModel->allByMatch($matchId),
        ];

        $filteredSets = [];
        $setNumber = 1;
        foreach ($sets as $set) {
            $pointsA = isset($set['points_a']) ? (int)$set['points_a'] : null;
            $pointsB = isset($set['points_b']) ? (int)$set['points_b'] : null;
            if ($pointsA === null || $pointsB === null) {
                continue;
            }
            $filteredSets[] = [
                'set_number' => $setNumber++,
                'points_a' => $pointsA,
                'points_b' => $pointsB,
            ];
        }

        $setModel->replaceSets($matchId, $filteredSets);
        [$winnerId, $status] = $this->determineWinner($match, $filteredSets);
        $matchModel->updateResult($matchId, $status, $winnerId);

        $after = [
            'match' => $matchModel->find($matchId),
            'sets' => $setModel->allByMatch($matchId),
        ];

        $auditModel->create([
            'user_id' => $userId,
            'entity_type' => 'match',
            'entity_id' => $matchId,
            'action' => 'update_result',
            'before_json' => json_encode($before, JSON_UNESCAPED_UNICODE),
            'after_json' => json_encode($after, JSON_UNESCAPED_UNICODE),
        ]);
    }

    private function determineWinner(array $match, array $sets): array
    {
        $bestOf = (int)$match['best_of_sets'];
        $needed = (int)ceil($bestOf / 2);
        $winsA = 0;
        $winsB = 0;

        foreach ($sets as $set) {
            if ($set['points_a'] > $set['points_b']) {
                $winsA++;
            } elseif ($set['points_b'] > $set['points_a']) {
                $winsB++;
            }
        }

        if ($winsA >= $needed) {
            return [(int)$match['player_a_id'], 'completed'];
        }
        if ($winsB >= $needed) {
            return [(int)$match['player_b_id'], 'completed'];
        }

        return [null, 'in_progress'];
    }
}
