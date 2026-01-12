<?php

namespace App\Models;

class BracketSlotModel extends Model
{
    public function create(array $data): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO bracket_slots (bracket_id, slot_no, seed, player_id)
             VALUES (:bracket_id, :slot_no, :seed, :player_id)'
        );
        $stmt->execute($data);
    }

    public function listByBracket(int $bracketId): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM bracket_slots WHERE bracket_id = :bracket_id ORDER BY slot_no'
        );
        $stmt->execute(['bracket_id' => $bracketId]);

        return $stmt->fetchAll();
    }
}
