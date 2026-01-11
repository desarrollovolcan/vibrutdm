<?php

declare(strict_types=1);

namespace App\Models;

class GroupModel extends BaseModel
{
    public function allByCategory(int $categoryId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM groups WHERE category_id = ? ORDER BY number');
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }

    public function create(int $categoryId, int $number): int
    {
        $stmt = $this->db->prepare('INSERT INTO groups (category_id, number) VALUES (?, ?)');
        $stmt->execute([$categoryId, $number]);
        return (int)$this->db->lastInsertId();
    }

    public function clearByCategory(int $categoryId): void
    {
        $stmt = $this->db->prepare('DELETE FROM groups WHERE category_id = ?');
        $stmt->execute([$categoryId]);
    }
}
