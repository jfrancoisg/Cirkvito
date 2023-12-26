<?php

declare(strict_types=1);

namespace App\Model;

final class Astar
{
    /**
     * @return array<string, array<int, array<string, int|string>>>
     */
    public function getGraph(): array
    {
        return [
            'd' => [
                ['film' => 'A', 'trajet' => 23, 'duree' => 110],
                ['film' => 'B', 'trajet' => 23, 'duree' => 90],
                ['film' => 'C', 'trajet' => 23, 'duree' => 90],
                ['film' => 'D', 'trajet' => 17, 'duree' => 90],
                ['film' => 'E', 'trajet' => 23, 'duree' => 90],
                ['film' => 'F', 'trajet' => 17, 'duree' => 90],
                ['film' => 'd', 'trajet' => 0, 'duree' => 0],
            ],
            'A' => [
                ['film' => 'B', 'trajet' => 0, 'duree' => 90],
                ['film' => 'C', 'trajet' => 0, 'duree' => 90],
                ['film' => 'D', 'trajet' => 0, 'duree' => 90],
                ['film' => 'F', 'trajet' => 33, 'duree' => 90],
                ['film' => 'd', 'trajet' => 13, 'duree' => 0],
            ],
            'B' => [
                ['film' => 'C', 'trajet' => 0, 'duree' => 90],
                ['film' => 'D', 'trajet' => 0, 'duree' => 90],
                ['film' => 'd', 'trajet' => 13, 'duree' => 0],
            ],
            'C' => [
                ['film' => 'D', 'trajet' => 0, 'duree' => 90],
                ['film' => 'd', 'trajet' => 13, 'duree' => 0],
            ],
            'D' => [
                ['film' => 'C', 'trajet' => 0, 'duree' => 90],
                ['film' => 'd', 'trajet' => 13, 'duree' => 0],
            ],
            'E' => [
                ['film' => 'B', 'trajet' => 13, 'duree' => 90],
                ['film' => 'C', 'trajet' => 13, 'duree' => 90],
                ['film' => 'D', 'trajet' => 13, 'duree' => 90],
                ['film' => 'F', 'trajet' => 13, 'duree' => 90],
                ['film' => 'd', 'trajet' => 13, 'duree' => 0],
            ],
            'F' => [
                ['film' => 'D', 'trajet' => 13, 'duree' => 90],
                ['film' => 'd', 'trajet' => 13, 'duree' => 0],
            ],
        ];
    }
}
