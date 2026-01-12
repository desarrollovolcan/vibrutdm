<?php

namespace App\Models;

class RegistrationModel extends Model
{
    public function listByCategory(int $categoryId): array
    {
        $stmt = $this->db->prepare(
            'SELECT r.*, p.first_name, p.last_name, p.association_id FROM registrations r
             JOIN players p ON p.id = r.player_id
             WHERE r.category_id = :category_id
             ORDER BY r.ranking_seed IS NULL, r.ranking_seed ASC'
        );
        $stmt->execute(['category_id' => $categoryId]);

        return $stmt->fetchAll();
    }

    public function create(int $categoryId, int $playerId, ?int $rankingSeed): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO registrations (category_id, player_id, ranking_seed) VALUES (:category_id, :player_id, :ranking_seed)'
        );
        $stmt->execute([
            'category_id' => $categoryId,
            'player_id' => $playerId,
            'ranking_seed' => $rankingSeed,
        ]);
    }

    public function delete(int $categoryId, int $playerId): void
    {
        $stmt = $this->db->prepare(
            'DELETE FROM registrations WHERE category_id = :category_id AND player_id = :player_id'
        );
        $stmt->execute([
            'category_id' => $categoryId,
            'player_id' => $playerId,
        ]);
    }
}
