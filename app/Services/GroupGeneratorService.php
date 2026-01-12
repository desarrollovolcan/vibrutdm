<?php

namespace App\Services;

use App\Models\CategoryModel;
use App\Models\GroupModel;
use App\Models\GroupPlayerModel;
use App\Models\RegistrationModel;

class GroupGeneratorService
{
    public function generate(int $categoryId, string $modo = 'snake'): array
    {
        $categoryModel = new CategoryModel();
        $registrationModel = new RegistrationModel();
        $groupModel = new GroupModel();
        $groupPlayerModel = new GroupPlayerModel();

        $category = $categoryModel->find($categoryId);
        if (!$category) {
            throw new \RuntimeException('Categoría no encontrada.');
        }

        $registrations = $registrationModel->listByCategory($categoryId);
        $playersPerGroup = (int) $category['players_per_group'];
        $totalPlayers = count($registrations);
        $nGroups = (int) ceil($totalPlayers / $playersPerGroup);

        $groups = [];
        for ($i = 1; $i <= $nGroups; $i++) {
            $groups[$i] = $groupModel->create($categoryId, $i);
        }

        if ($modo === 'snake') {
            $direction = 1;
            $groupIndex = 1;
            $positionByGroup = array_fill(1, $nGroups, 1);

            foreach ($registrations as $registration) {
                $groupId = $groups[$groupIndex];
                $groupPlayerModel->addPlayer($groupId, (int) $registration['player_id'], $positionByGroup[$groupIndex]++);

                if ($direction === 1 && $groupIndex === $nGroups) {
                    $direction = -1;
                } elseif ($direction === -1 && $groupIndex === 1) {
                    $direction = 1;
                }

                $groupIndex += $direction;
            }
        } else {
            $positionByGroup = array_fill(1, $nGroups, 1);
            $groupPlayers = array_fill(1, $nGroups, []);

            foreach ($registrations as $registration) {
                $chosenGroup = null;
                $associationId = $registration['association_id'];
                $minCount = PHP_INT_MAX;

                foreach ($groups as $index => $groupId) {
                    $currentCount = count($groupPlayers[$index]);
                    $hasAssociation = $associationId && in_array($associationId, $groupPlayers[$index], true);

                    if (!$hasAssociation && $currentCount < $minCount) {
                        $minCount = $currentCount;
                        $chosenGroup = $index;
                    }
                }

                if ($chosenGroup === null) {
                    $chosenGroup = array_search(min(array_map('count', $groupPlayers)), array_map('count', $groupPlayers), true);
                }

                $groupId = $groups[$chosenGroup];
                $groupPlayerModel->addPlayer($groupId, (int) $registration['player_id'], $positionByGroup[$chosenGroup]++);
                $groupPlayers[$chosenGroup][] = $associationId;
            }
        }

        return $groups;
    }
}
