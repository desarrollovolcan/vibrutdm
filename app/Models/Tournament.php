<?php

declare(strict_types=1);

namespace App\Models;

class Tournament extends BaseModel
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM tournaments ORDER BY date_start DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM tournaments WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO tournaments (name, venue, date_start, status, created_at) VALUES (?, ?, ?, ?, NOW())');
        $stmt->execute([
            $data['name'],
            $data['venue'],
            $data['date_start'],
            $data['status'],
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('UPDATE tournaments SET name = ?, venue = ?, date_start = ?, status = ? WHERE id = ?');
        $stmt->execute([
            $data['name'],
            $data['venue'],
            $data['date_start'],
            $data['status'],
            $id,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM tournaments WHERE id = ?');
        $stmt->execute([$id]);
    }
}
