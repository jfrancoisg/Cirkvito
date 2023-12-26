<?php

declare(strict_types=1);

namespace App\Controller;

use App\App;

final class AstarController extends CoreController
{
    public function index(): void
    {
        $data = [];
        $graph = App::getModel('Astar')->getGraph();
        $data['circuits'] = $this->trouverCircuits($graph);

        $this->render(
            'index',
            $data
        );
    }

    /**
     * @param array<string> $graph graph
     *
     * @return array<string>
     */
    public function trouverCircuits(array $graph): array
    {
        $circuits = [];

        foreach (array_keys($graph) as $sommet) {
            $this->dfs($sommet, [], 0, 0, $graph, $circuits);
        }

        return $circuits;
    }

    /**
     * @param array<string> $chemin
     * @param array<string> $graph
     * @param array<string> $circuits
     */
    public function dfs(
        string $v = '',
        array $chemin = [],
        int $trajet = 0,
        int $duree = 0,
        array $graph = [],
        array &$circuits = [],
    ): void {
        $chemin[] = $v;
        foreach ($graph[$v] as $voisin) {
            $voisin = [$voisin['film'], $voisin['duree'], $voisin['trajet']];
            [$vFilm, $vDuree, $vtrajet] = $voisin;

            if ($vFilm === $chemin[0] && $vFilm === 'd') {
                $circuits[] = $this->gen(
                    $chemin,
                    $vFilm,
                    $trajet,
                    $vtrajet,
                    $duree,
                    $vDuree
                );
            } elseif (!in_array($vFilm, $chemin)) {
                [$p, $d] = [$trajet + $vtrajet, $duree + $vDuree];
                $this->dfs($vFilm, $chemin, $p, $d, $graph, $circuits);
            }
        }

        array_pop($chemin);
    }

    /**
     * @param array<string> $chemin Chemin entre deux salles
     *
     * @return array<string, array<string>|int>
     */
    private function gen(
        array $chemin,
        string $vFilm,
        int $trajet,
        int $vPoids,
        int $duree,
        int $vDuree
    ): array {
        return [
            'chemin' => [...$chemin, $vFilm],
            'tempsTrajet' => $trajet + $vPoids,
            'dureeFilmTotal' => $duree + $vDuree,
        ];
    }
}
