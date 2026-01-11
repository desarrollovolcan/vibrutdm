<?php

declare(strict_types=1);

namespace App\Models;

class Player extends BaseModel
{
    public function all(): array
    {
        $sql = 'SELECT p.*, a.name AS association_name FROM players p LEFT JOIN associations a ON a.id = p.association_id ORDER BY p.name';
        return $this->db->query($sql)->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM players WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO players (name, association_id, ranking_seed, created_at) VALUES (?, ?, ?, NOW())');
        $stmt->execute([
            $data['name'],
            $data['association_id'] ?: null,
            $data['ranking_seed'] ?: null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('UPDATE players SET name = ?, association_id = ?, ranking_seed = ? WHERE id = ?');
        $stmt->execute([
            $data['name'],
            $data['association_id'] ?: null,
            $data['ranking_seed'] ?: null,
            $id,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM players WHERE id = ?');
        $stmt->execute([$id]);
    }
}
