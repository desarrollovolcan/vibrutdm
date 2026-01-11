<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\GroupModel;
use App\Models\GroupPlayer;
use App\Models\Registration;

class GroupGeneratorService
{
    public function generate(int $categoryId, int $groupSize, bool $avoidSameAssociation = false): array
    {
        $registrationModel = new Registration();
        $groupModel = new GroupModel();
        $groupPlayerModel = new GroupPlayer();

        $registrations = $registrationModel->allByCategory($categoryId);
        $total = count($registrations);
        if ($total === 0) {
            return ['groups' => 0, 'message' => 'No hay inscripciones.'];
        }

        $groups = (int)ceil($total / $groupSize);

        $groupModel->clearByCategory($categoryId);
        $groupPlayerModel->clearByCategory($categoryId);

        $groupIds = [];
        for ($i = 1; $i <= $groups; $i++) {
            $groupIds[$i] = $groupModel->create($categoryId, $i);
        }

        $ordered = $this->snakeOrder($registrations);
        $assignments = $this->assignPlayers($ordered, $groups, $avoidSameAssociation);

        foreach ($assignments as $groupNumber => $players) {
            $position = 1;
            foreach ($players as $player) {
                $groupPlayerModel->add($groupIds[$groupNumber], $player['player_id'], $position++);
            }
        }

        return ['groups' => $groups, 'message' => 'Grupos generados correctamente.'];
    }

    private function snakeOrder(array $registrations): array
    {
        $result = [];
        $chunk = 0;
        $chunkSize = 1;
        $index = 0;
        $direction = 1;

        while ($index < count($registrations)) {
            $slice = array_slice($registrations, $index, $chunkSize);
            if ($direction === -1) {
                $slice = array_reverse($slice);
            }
            $result = array_merge($result, $slice);
            $index += $chunkSize;
            $chunk++;
            if ($chunk % 2 === 0) {
                $direction *= -1;
            }
        }

        return $result;
    }

    private function assignPlayers(array $ordered, int $groups, bool $avoidSameAssociation): array
    {
        $assignments = array_fill(1, $groups, []);
        $groupIndex = 1;
        $direction = 1;

        foreach ($ordered as $player) {
            $targetGroup = $groupIndex;
            if ($avoidSameAssociation && $player['association_id']) {
                $targetGroup = $this->findGroupWithoutAssociation($assignments, $player['association_id'], $groupIndex, $direction);
            }
            $assignments[$targetGroup][] = $player;
            $groupIndex += $direction;
            if ($groupIndex > $groups) {
                $groupIndex = $groups;
                $direction = -1;
            } elseif ($groupIndex < 1) {
                $groupIndex = 1;
                $direction = 1;
            }
        }

        return $assignments;
    }

    private function findGroupWithoutAssociation(array $assignments, int $associationId, int $fallback, int $direction): int
    {
        $groupNumbers = array_keys($assignments);
        if ($direction === -1) {
            $groupNumbers = array_reverse($groupNumbers);
        }
        foreach ($groupNumbers as $groupNumber) {
            $hasAssociation = false;
            foreach ($assignments[$groupNumber] as $player) {
                if ((int)$player['association_id'] === $associationId) {
                    $hasAssociation = true;
                    break;
                }
            }
            if (!$hasAssociation) {
                return $groupNumber;
            }
        }
        return $fallback;
    }
}
