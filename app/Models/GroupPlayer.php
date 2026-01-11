<?php

declare(strict_types=1);

namespace App\Models;

class GroupPlayer extends BaseModel
{
    public function add(int $groupId, int $playerId, int $position): void
    {
        $stmt = $this->db->prepare('INSERT INTO group_players (group_id, player_id, position) VALUES (?, ?, ?)');
        $stmt->execute([$groupId, $playerId, $position]);
    }

    public function allByGroup(int $groupId): array
    {
        $sql = 'SELECT gp.*, p.name AS player_name, a.name AS association_name
                FROM group_players gp
                JOIN players p ON p.id = gp.player_id
                LEFT JOIN associations a ON a.id = p.association_id
                WHERE gp.group_id = ?
                ORDER BY gp.position';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId]);
        return $stmt->fetchAll();
    }

    public function clearByCategory(int $categoryId): void
    {
        $sql = 'DELETE gp FROM group_players gp JOIN groups g ON g.id = gp.group_id WHERE g.category_id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId]);
    }
}
