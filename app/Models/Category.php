<?php

declare(strict_types=1);

namespace App\Models;

class Category extends BaseModel
{
    public function allByTournament(int $tournamentId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE tournament_id = ? ORDER BY id DESC');
        $stmt->execute([$tournamentId]);
        return $stmt->fetchAll();
    }

    public function all(): array
    {
        return $this->db->query('SELECT c.*, t.name AS tournament_name FROM categories c JOIN tournaments t ON t.id = c.tournament_id ORDER BY c.id DESC')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO categories (tournament_id, name, group_size, qualify_per_group, best_of_sets, points_per_set, bracket_size, tiebreak_criteria, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute([
            $data['tournament_id'],
            $data['name'],
            $data['group_size'],
            $data['qualify_per_group'],
            $data['best_of_sets'],
            $data['points_per_set'],
            $data['bracket_size'],
            $data['tiebreak_criteria'],
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare('UPDATE categories SET tournament_id = ?, name = ?, group_size = ?, qualify_per_group = ?, best_of_sets = ?, points_per_set = ?, bracket_size = ?, tiebreak_criteria = ? WHERE id = ?');
        $stmt->execute([
            $data['tournament_id'],
            $data['name'],
            $data['group_size'],
            $data['qualify_per_group'],
            $data['best_of_sets'],
            $data['points_per_set'],
            $data['bracket_size'],
            $data['tiebreak_criteria'],
            $id,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare('DELETE FROM categories WHERE id = ?');
        $stmt->execute([$id]);
    }
}
