<?php

declare(strict_types=1);

namespace App\Models;

class Bracket extends BaseModel
{
    public function findByCategory(int $categoryId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM brackets WHERE category_id = ?');
        $stmt->execute([$categoryId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(int $categoryId, int $size): int
    {
        $stmt = $this->db->prepare('INSERT INTO brackets (category_id, size, created_at) VALUES (?, ?, NOW())');
        $stmt->execute([$categoryId, $size]);
        return (int)$this->db->lastInsertId();
    }

    public function deleteByCategory(int $categoryId): void
    {
        $stmt = $this->db->prepare('DELETE FROM brackets WHERE category_id = ?');
        $stmt->execute([$categoryId]);
    }
}
