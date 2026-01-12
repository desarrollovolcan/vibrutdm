<?php

namespace App\Models;

class GroupStandingModel extends Model
{
    public function upsert(array $data): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO group_standings (group_id, player_id, matches_won, matches_lost, sets_won, sets_lost, points_for, points_against, rank_pos)
             VALUES (:group_id, :player_id, :matches_won, :matches_lost, :sets_won, :sets_lost, :points_for, :points_against, :rank_pos)
             ON DUPLICATE KEY UPDATE
                matches_won = VALUES(matches_won),
                matches_lost = VALUES(matches_lost),
                sets_won = VALUES(sets_won),
                sets_lost = VALUES(sets_lost),
                points_for = VALUES(points_for),
                points_against = VALUES(points_against),
                rank_pos = VALUES(rank_pos)'
        );
        $stmt->execute($data);
    }

    public function topNByGroup(int $groupId, int $limit): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM group_standings WHERE group_id = :group_id ORDER BY rank_pos ASC LIMIT :limit'
        );
        $stmt->bindValue('group_id', $groupId, \PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
