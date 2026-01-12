<?php

namespace App\Models;

class MatchSetModel extends Model
{
    public function upsert(int $matchId, int $setNumber, int $pointsA, int $pointsB): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO match_sets (match_id, set_number, points_a, points_b)
             VALUES (:match_id, :set_number, :points_a, :points_b)
             ON DUPLICATE KEY UPDATE points_a = VALUES(points_a), points_b = VALUES(points_b)'
        );
        $stmt->execute([
            'match_id' => $matchId,
            'set_number' => $setNumber,
            'points_a' => $pointsA,
            'points_b' => $pointsB,
        ]);
    }

    public function listByMatch(int $matchId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM match_sets WHERE match_id = :match_id ORDER BY set_number');
        $stmt->execute(['match_id' => $matchId]);

        return $stmt->fetchAll();
    }
}
