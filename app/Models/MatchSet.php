<?php

declare(strict_types=1);

namespace App\Models;

class MatchSet extends BaseModel
{
    public function allByMatch(int $matchId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM match_sets WHERE match_id = ? ORDER BY set_number');
        $stmt->execute([$matchId]);
        return $stmt->fetchAll();
    }

    public function replaceSets(int $matchId, array $sets): void
    {
        $stmt = $this->db->prepare('DELETE FROM match_sets WHERE match_id = ?');
        $stmt->execute([$matchId]);
        $insert = $this->db->prepare('INSERT INTO match_sets (match_id, set_number, points_a, points_b) VALUES (?, ?, ?, ?)');
        foreach ($sets as $set) {
            $insert->execute([$matchId, $set['set_number'], $set['points_a'], $set['points_b']]);
        }
    }
}
