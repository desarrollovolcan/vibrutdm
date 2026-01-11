<?php

declare(strict_types=1);

namespace App\Models;

class Registration extends BaseModel
{
    public function allByCategory(int $categoryId): array
    {
        $sql = 'SELECT r.*, p.name AS player_name, p.association_id, a.name AS association_name
                FROM registrations r
                JOIN players p ON p.id = r.player_id
                LEFT JOIN associations a ON a.id = p.association_id
                WHERE r.category_id = ?
                ORDER BY COALESCE(r.ranking_seed, 9999), p.name';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO registrations (category_id, player_id, ranking_seed) VALUES (?, ?, ?)');
        $stmt->execute([
            $data['category_id'],
            $data['player_id'],
            $data['ranking_seed'] ?: null,
        ]);
    }

    public function delete(int $categoryId, int $playerId): void
    {
        $stmt = $this->db->prepare('DELETE FROM registrations WHERE category_id = ? AND player_id = ?');
        $stmt->execute([$categoryId, $playerId]);
    }
}
