<?php

namespace App\Models;

class BracketModel extends Model
{
    public function create(int $categoryId, int $size): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO brackets (category_id, size) VALUES (:category_id, :size)'
        );
        $stmt->execute([
            'category_id' => $categoryId,
            'size' => $size,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function findByCategory(int $categoryId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM brackets WHERE category_id = :category_id ORDER BY id DESC LIMIT 1');
        $stmt->execute(['category_id' => $categoryId]);
        $bracket = $stmt->fetch();

        return $bracket ?: null;
    }
}
