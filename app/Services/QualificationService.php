<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\GroupModel;
use App\Models\GroupStanding;

class QualificationService
{
    public function selectQualified(int $categoryId, int $qualifyPerGroup, int $bracketSize): array
    {
        $groupModel = new GroupModel();
        $standingModel = new GroupStanding();
        $groups = $groupModel->allByCategory($categoryId);
        $all = [];
        $winners = [];

        foreach ($groups as $group) {
            $standings = $standingModel->allByGroup((int)$group['id']);
            foreach ($standings as $row) {
                $row['group_id'] = (int)$group['id'];
                $all[] = $row;
                if ((int)$row['rank_pos'] === 1) {
                    $winners[] = $row;
                }
            }
        }

        $qualified = [];
        foreach ($groups as $group) {
            $standings = $standingModel->allByGroup((int)$group['id']);
            foreach ($standings as $row) {
                if ((int)$row['rank_pos'] <= $qualifyPerGroup) {
                    $row['group_id'] = (int)$group['id'];
                    $qualified[] = $row;
                }
            }
        }

        if (count($qualified) > $bracketSize) {
            $selected = $winners;
            $remaining = array_filter($qualified, fn($row) => (int)$row['rank_pos'] > 1);
            $remaining = $this->sortGlobal($remaining);
            foreach ($remaining as $row) {
                if (count($selected) >= $bracketSize) {
                    break;
                }
                $selected[] = $row;
            }
            return $selected;
        }

        return $qualified;
    }

    private function sortGlobal(array $rows): array
    {
        usort($rows, function ($a, $b) {
            if ($a['matches_won'] !== $b['matches_won']) {
                return $b['matches_won'] <=> $a['matches_won'];
            }
            $ratioA = $this->ratio((int)$a['sets_won'], (int)$a['sets_lost']);
            $ratioB = $this->ratio((int)$b['sets_won'], (int)$b['sets_lost']);
            if ($ratioA !== $ratioB) {
                return $ratioB <=> $ratioA;
            }
            $pointsRatioA = $this->ratio((int)$a['points_for'], (int)$a['points_against']);
            $pointsRatioB = $this->ratio((int)$b['points_for'], (int)$b['points_against']);
            if ($pointsRatioA !== $pointsRatioB) {
                return $pointsRatioB <=> $pointsRatioA;
            }
            return 0;
        });
        return $rows;
    }

    private function ratio(int $won, int $lost): float
    {
        return $lost === 0 ? (float)$won : $won / $lost;
    }
}
