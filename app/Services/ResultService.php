<?php

namespace App\Services;

use App\Models\AuditLogModel;
use App\Models\MatchModel;
use App\Models\MatchSetModel;

class ResultService
{
    public function saveSets(int $matchId, array $sets, int $userId): void
    {
        $matchModel = new MatchModel();
        $matchSetModel = new MatchSetModel();
        $auditLogModel = new AuditLogModel();

        $match = $matchModel->find($matchId);
        if (!$match) {
            throw new \RuntimeException('Match no encontrado.');
        }

        $before = $match;

        foreach ($sets as $index => $set) {
            if (!is_numeric($set['points_a']) || !is_numeric($set['points_b'])) {
                throw new \InvalidArgumentException('Puntajes inválidos.');
            }

            $matchSetModel->upsert(
                $matchId,
                (int) $index,
                (int) $set['points_a'],
                (int) $set['points_b']
            );
        }

        $winnerId = $this->computeWinner($matchId);
        $status = $winnerId ? 'finished' : 'pending';

        $matchModel->update($matchId, [
            'status' => $status,
            'winner_id' => $winnerId,
            'player_a_id' => $match['player_a_id'],
            'player_b_id' => $match['player_b_id'],
        ]);

        $after = $matchModel->find($matchId);

        $auditLogModel->create([
            'user_id' => $userId,
            'entity_type' => 'match',
            'entity_id' => $matchId,
            'before_json' => json_encode($before, JSON_UNESCAPED_UNICODE),
            'after_json' => json_encode($after, JSON_UNESCAPED_UNICODE),
        ]);
    }

    public function computeWinner(int $matchId): ?int
    {
        $matchModel = new MatchModel();
        $matchSetModel = new MatchSetModel();

        $match = $matchModel->find($matchId);
        if (!$match) {
            return null;
        }

        $bestOfSets = (int) $match['best_of_sets'];
        $needed = (int) ceil($bestOfSets / 2);

        $sets = $matchSetModel->listByMatch($matchId);
        $winsA = 0;
        $winsB = 0;

        foreach ($sets as $set) {
            if ($set['points_a'] > $set['points_b']) {
                $winsA++;
            } elseif ($set['points_b'] > $set['points_a']) {
                $winsB++;
            }

            if ($winsA >= $needed) {
                return (int) $match['player_a_id'];
            }
            if ($winsB >= $needed) {
                return (int) $match['player_b_id'];
            }
        }

        return null;
    }
}
