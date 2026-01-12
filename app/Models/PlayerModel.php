<?php

namespace App\Models;

class PlayerModel extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM players ORDER BY last_name, first_name')->fetchAll();
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO players (first_name, last_name, association_id, ranking_points) VALUES (:first_name, :last_name, :association_id, :ranking_points)'
        );
        $stmt->execute([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'association_id' => $data['association_id'],
            'ranking_points' => $data['ranking_points'],
        ]);

        return (int) $this->db->lastInsertId();
    }
}
