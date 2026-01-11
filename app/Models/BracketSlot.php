<?php

declare(strict_types=1);

namespace App\Models;

class BracketSlot extends BaseModel
{
    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO bracket_slots (bracket_id, slot_number, player_id, source_type, source_group_id, source_rank) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['bracket_id'],
            $data['slot_number'],
            $data['player_id'],
            $data['source_type'],
            $data['source_group_id'],
            $data['source_rank'],
        ]);
    }

    public function allByBracket(int $bracketId): array
    {
        $sql = 'SELECT bs.*, p.name AS player_name
                FROM bracket_slots bs
                LEFT JOIN players p ON p.id = bs.player_id
                WHERE bs.bracket_id = ?
                ORDER BY bs.slot_number';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$bracketId]);
        return $stmt->fetchAll();
    }

    public function clearByBracket(int $bracketId): void
    {
        $stmt = $this->db->prepare('DELETE FROM bracket_slots WHERE bracket_id = ?');
        $stmt->execute([$bracketId]);
    }
}
