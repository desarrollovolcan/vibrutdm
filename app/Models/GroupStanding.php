<?php

declare(strict_types=1);

namespace App\Models;

class GroupStanding extends BaseModel
{
    public function allByGroup(int $groupId): array
    {
        $sql = 'SELECT gs.*, p.name AS player_name
                FROM group_standings gs
                JOIN players p ON p.id = gs.player_id
                WHERE gs.group_id = ?
                ORDER BY gs.rank_pos';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId]);
        return $stmt->fetchAll();
    }

    public function replace(int $groupId, array $rows): void
    {
        $stmt = $this->db->prepare('DELETE FROM group_standings WHERE group_id = ?');
        $stmt->execute([$groupId]);
        $insert = $this->db->prepare('INSERT INTO group_standings (group_id, player_id, matches_played, matches_won, matches_lost, sets_won, sets_lost, points_for, points_against, rank_pos, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())');
        foreach ($rows as $row) {
            $insert->execute([
                $groupId,
                $row['player_id'],
                $row['matches_played'],
                $row['matches_won'],
                $row['matches_lost'],
                $row['sets_won'],
                $row['sets_lost'],
                $row['points_for'],
                $row['points_against'],
                $row['rank_pos'],
            ]);
        }
    }
}
