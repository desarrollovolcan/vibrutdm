<?php

namespace App\Models;

class GroupPlayerModel extends Model
{
    public function addPlayer(int $groupId, int $playerId, int $position): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO group_players (group_id, player_id, position) VALUES (:group_id, :player_id, :position)'
        );
        $stmt->execute([
            'group_id' => $groupId,
            'player_id' => $playerId,
            'position' => $position,
        ]);
    }

    public function listByGroup(int $groupId): array
    {
        $stmt = $this->db->prepare(
            'SELECT gp.*, p.first_name, p.last_name, p.association_id FROM group_players gp
             JOIN players p ON p.id = gp.player_id
             WHERE gp.group_id = :group_id
             ORDER BY gp.position'
        );
        $stmt->execute(['group_id' => $groupId]);

        return $stmt->fetchAll();
    }
}
