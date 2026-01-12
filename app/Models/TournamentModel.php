<?php

namespace App\Models;

class TournamentModel extends Model
{
    public function all(): array
    {
        return $this->db->query('SELECT * FROM tournaments ORDER BY start_date DESC')->fetchAll();
    }

    public function first(): ?array
    {
        $stmt = $this->db->query('SELECT * FROM tournaments ORDER BY start_date DESC LIMIT 1');
        $tournament = $stmt->fetch();

        return $tournament ?: null;
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM tournaments WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $tournament = $stmt->fetch();

        return $tournament ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO tournaments (name, location, start_date, end_date, status) VALUES (:name, :location, :start_date, :end_date, :status)'
        );
        $stmt->execute([
            'name' => $data['name'],
            'location' => $data['location'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status'] ?? 'draft',
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare(
            'UPDATE tournaments SET name = :name, location = :location, start_date = :start_date, end_date = :end_date, status = :status WHERE id = :id'
        );
        $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'location' => $data['location'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status'] ?? 'draft',
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM tournaments WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
