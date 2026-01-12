<?php

namespace App\Models;

class MatchModel extends Model
{
    public function create(array $data): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO matches (category_id, phase, group_id, bracket_id, round_number, match_index, player_a_id, player_b_id, best_of_sets, status)
             VALUES (:category_id, :phase, :group_id, :bracket_id, :round_number, :match_index, :player_a_id, :player_b_id, :best_of_sets, :status)'
        );
        $stmt->execute([
            'category_id' => $data['category_id'],
            'phase' => $data['phase'],
            'group_id' => $data['group_id'],
            'bracket_id' => $data['bracket_id'],
            'round_number' => $data['round_number'],
            'match_index' => $data['match_index'],
            'player_a_id' => $data['player_a_id'],
            'player_b_id' => $data['player_b_id'],
            'best_of_sets' => $data['best_of_sets'],
            'status' => $data['status'] ?? 'pending',
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM matches WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $match = $stmt->fetch();

        return $match ?: null;
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->db->prepare(
            'UPDATE matches SET status = :status, winner_id = :winner_id, player_a_id = :player_a_id, player_b_id = :player_b_id WHERE id = :id'
        );
        $stmt->execute([
            'id' => $id,
            'status' => $data['status'],
            'winner_id' => $data['winner_id'],
            'player_a_id' => $data['player_a_id'],
            'player_b_id' => $data['player_b_id'],
        ]);
    }

    public function listFinishedByGroup(int $groupId): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM matches WHERE group_id = :group_id AND status = "finished"'
        );
        $stmt->execute(['group_id' => $groupId]);

        return $stmt->fetchAll();
    }

    public function listByGroup(int $groupId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM matches WHERE group_id = :group_id ORDER BY id');
        $stmt->execute(['group_id' => $groupId]);

        return $stmt->fetchAll();
    }

    public function listByBracket(int $bracketId): array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM matches WHERE bracket_id = :bracket_id ORDER BY round_number, match_index'
        );
        $stmt->execute(['bracket_id' => $bracketId]);

        return $stmt->fetchAll();
    }

    public function findByBracketRoundIndex(int $bracketId, int $round, int $matchIndex): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM matches WHERE bracket_id = :bracket_id AND round_number = :round_number AND match_index = :match_index LIMIT 1'
        );
        $stmt->execute([
            'bracket_id' => $bracketId,
            'round_number' => $round,
            'match_index' => $matchIndex,
        ]);
        $match = $stmt->fetch();

        return $match ?: null;
    }
}
