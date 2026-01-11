<?php

declare(strict_types=1);

namespace App\Models;

class Association extends BaseModel
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM associations ORDER BY name')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM associations WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO associations (name, created_at) VALUES (?, NOW())');
        $stmt->execute([$data['name']]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('UPDATE associations SET name = ? WHERE id = ?');
        $stmt->execute([$data['name'], $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM associations WHERE id = ?');
        $stmt->execute([$id]);
    }
}
