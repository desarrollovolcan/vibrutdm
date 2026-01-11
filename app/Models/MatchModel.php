<?php

declare(strict_types=1);

namespace App\Models;

class MatchModel extends BaseModel
{
    public function create(array $data): int
    {
        $stmt = $this->db->prepare('INSERT INTO matches (phase, category_id, group_id, bracket_id, round_number, match_number, player_a_id, player_b_id, status, winner_id, best_of_sets, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute([
            $data['phase'],
            $data['category_id'],
            $data['group_id'],
            $data['bracket_id'],
            $data['round_number'],
            $data['match_number'],
            $data['player_a_id'],
            $data['player_b_id'],
            $data['status'],
            $data['winner_id'],
            $data['best_of_sets'],
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM matches WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findWithNames(int $id): ?array
    {
        $sql = 'SELECT m.*, pa.name AS player_a_name, pb.name AS player_b_name
                FROM matches m
                LEFT JOIN players pa ON pa.id = m.player_a_id
                LEFT JOIN players pb ON pb.id = m.player_b_id
                WHERE m.id = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function updateResult(int $id, string $status, ?int $winnerId): void
    {
        $stmt = $this->db->prepare('UPDATE matches SET status = ?, winner_id = ? WHERE id = ?');
        $stmt->execute([$status, $winnerId, $id]);
    }

    public function updatePlayers(int $id, ?int $playerAId, ?int $playerBId): void
    {
        $stmt = $this->db->prepare('UPDATE matches SET player_a_id = ?, player_b_id = ? WHERE id = ?');
        $stmt->execute([$playerAId, $playerBId, $id]);
    }

    public function allByGroup(int $groupId): array
    {
        $sql = 'SELECT m.*, pa.name AS player_a_name, pb.name AS player_b_name
                FROM matches m
                LEFT JOIN players pa ON pa.id = m.player_a_id
                LEFT JOIN players pb ON pb.id = m.player_b_id
                WHERE m.group_id = ?
                ORDER BY m.id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId]);
        return $stmt->fetchAll();
    }

    public function allByCategoryPhase(int $categoryId, string $phase): array
    {
        $sql = 'SELECT m.*, pa.name AS player_a_name, pb.name AS player_b_name
                FROM matches m
                LEFT JOIN players pa ON pa.id = m.player_a_id
                LEFT JOIN players pb ON pb.id = m.player_b_id
                WHERE m.category_id = ? AND m.phase = ?
                ORDER BY m.round_number, m.match_number';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId, $phase]);
        return $stmt->fetchAll();
    }

    public function latest(int $limit = 5): array
    {
        $sql = 'SELECT m.*, pa.name AS player_a_name, pb.name AS player_b_name
                FROM matches m
                LEFT JOIN players pa ON pa.id = m.player_a_id
                LEFT JOIN players pb ON pb.id = m.player_b_id
                ORDER BY m.created_at DESC
                LIMIT ?';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findBracketMatch(int $bracketId, int $round, int $matchNumber): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM matches WHERE bracket_id = ? AND round_number = ? AND match_number = ? LIMIT 1');
        $stmt->execute([$bracketId, $round, $matchNumber]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function allByBracketRound(int $bracketId, int $round): array
    {
        $stmt = $this->db->prepare('SELECT * FROM matches WHERE bracket_id = ? AND round_number = ?');
        $stmt->execute([$bracketId, $round]);
        return $stmt->fetchAll();
    }

    public function clearByCategoryPhase(int $categoryId, string $phase): void
    {
        $stmt = $this->db->prepare('DELETE FROM matches WHERE category_id = ? AND phase = ?');
        $stmt->execute([$categoryId, $phase]);
    }
}
