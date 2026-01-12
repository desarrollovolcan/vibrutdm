<?php

namespace App\Models;

class CategoryModel extends Model
{
    public function listByTournament(int $tournamentId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE tournament_id = :tournament_id ORDER BY name');
        $stmt->execute(['tournament_id' => $tournamentId]);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $category = $stmt->fetch();

        return $category ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO categories (tournament_id, name, players_per_group, qualify_per_group, best_of_sets, bracket_size) VALUES (:tournament_id, :name, :players_per_group, :qualify_per_group, :best_of_sets, :bracket_size)'
        );
        $stmt->execute([
            'tournament_id' => $data['tournament_id'],
            'name' => $data['name'],
            'players_per_group' => $data['players_per_group'],
            'qualify_per_group' => $data['qualify_per_group'],
            'best_of_sets' => $data['best_of_sets'],
            'bracket_size' => $data['bracket_size'],
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare(
            'UPDATE categories SET name = :name, players_per_group = :players_per_group, qualify_per_group = :qualify_per_group, best_of_sets = :best_of_sets, bracket_size = :bracket_size WHERE id = :id'
        );
        $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'players_per_group' => $data['players_per_group'],
            'qualify_per_group' => $data['qualify_per_group'],
            'best_of_sets' => $data['best_of_sets'],
            'bracket_size' => $data['bracket_size'],
        ]);
    }
}
