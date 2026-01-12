<?php

namespace App\Models;

class GroupModel extends Model
{
    public function create(int $categoryId, int $groupNumber): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO groups (category_id, group_number) VALUES (:category_id, :group_number)'
        );
        $stmt->execute([
            'category_id' => $categoryId,
            'group_number' => $groupNumber,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function listByCategory(int $categoryId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM groups WHERE category_id = :category_id ORDER BY group_number');
        $stmt->execute(['category_id' => $categoryId]);

        return $stmt->fetchAll();
    }
}
