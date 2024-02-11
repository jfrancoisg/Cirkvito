<?php

declare(strict_types=1);

namespace App\Controller;

use App\App;
use DateInterval;
use DateTimeImmutable;

final class SeanceController extends CoreController
{
    private int $tpsAvantSeance = 10;
    private int $tpsSortieSalle = 2;

    public function index(): void
    {
        echo 'ACCUEIL';
        $this->render(
            'index'
        );
    }

    public function filtre(): void
    {
        $data = [];
        $data['films'] = App::getModel('film')->getList();
        $data['salles'] = App::getModel('salle')->getList();

        $this->render(
            'filtre',
            $data
        );
    }

    public function circuits(): void
    {
        $data = [];

        $data['circuits'] = $this->trouverCircuits($this->getGraph());

        $this->render(
            'seances',
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
            $this->dfs($sommet, [], $graph, $circuits);
        }

        return $circuits;
    }

    /**
     * @param array<int|string> $chemin
     * @param array<string> $graph
     * @param array<string> $circuits
     */
    public function dfs(
        string|int $idSeanceCourrente = '',
        array $chemin = [],
        array $graph = [],
        array &$circuits = [],
    ): void {
        $chemin[] = $idSeanceCourrente;

        if ($graph[$idSeanceCourrente] !== []) {
            foreach ($graph[$idSeanceCourrente] ?? [] as $suivant) {
                if ($suivant['idSeance'] === $chemin[0] && $suivant['idSeance'] === 0) {
                    $circuits[] = $this->gen($chemin);
                } elseif (!isset($chemin[$suivant['idSeance']])) {
                    $this->dfs($suivant['idSeance'], $chemin, $graph, $circuits);
                }
            }
        }

        array_pop($chemin);
    }

    /**
     * @param array<int|string> $chemin séance
     *
     * @return array<string, array<int|string>>
     */
    public function gen(
        array $chemin,
    ): array {
        $infos = App::getModel('seance');

        foreach ($chemin as &$value) {
            $value = $infos->getById($value);
        }

        return [
            'chemin' => $chemin,
        ];
    }

    /**
     * Crée la liste de toutes les séances visionables (toutes les séances).
     *
     * @return array<int, array<int, mixed>>
     */
    public function createFirstLine(): array
    {
        $firstLine = [0 => []];

        $post = $this->postFilter();
        $ids = App::getModel('seance')->getAllWithFilters($post);
        // dump(App::getModel('seance')->getAllWithFilters($post));
        foreach ($ids as $id) {
            $firstLine[0][] = $id;
        }

        $firstLine[0][] = $this->insertD();

        return $firstLine;
    }

    /**
     * @param array<string> $graph Graph des séances
     * @param ?string $debutCircuit Liste des films à inclure dans le circuit
     * @param ?string $finCircuit Liste des salles à inclure dans le circuit
     *
     * @return array<int, array<int, mixed>>
     */
    public function createCircuits(
        array $graph,
        ?string $debutCircuit = null,
        ?string $finCircuit = null,
    ): array {
        $seances = App::getModel('seance');
        $post = $this->postFilter();
        $listeSeances = $seances->getAllWithFilters($post);
        $listFilmVus = [];

        foreach ($listeSeances as $seance) {
            ['idSeance' => $idSeance, 'idFilm' => $idFilm, 'idSalle' => $idSalle] = $seance;

            $graph[$idSeance] = [];
            $heureDebutSeance = new DateTimeImmutable($seance['heureDebut']);
            $heureFinSeance = new DateTimeImmutable($seance['heureFin']);

            foreach ($listeSeances as $infosSeance) {
                /** Alimente un tableau avec les films vu
                 * pour ne pas les insérer de nouveau dans un chemin.
                 */
                array_push($listFilmVus, $idFilm);

                $heureDebut = $debutCircuit !== null ? new DateTimeImmutable($debutCircuit) : null;
                $heureFin = $finCircuit !== null ? new DateTimeImmutable($finCircuit) : null;

                $idSalleSuivante = $infosSeance['idSalle'];
                $dist = $seances->distBetween2Point($idSalle, $idSalleSuivante);

                /** Crée l'interval à partir d'une chaine de caractère */

                if ($dist !== 0) {
                    $heurePlusTrajet = DateInterval::createFromDateString(
                        $dist + $this->tpsSortieSalle + $this->tpsAvantSeance . ' minutes'
                    );
                } else {
                    $heurePlusTrajet = DateInterval::createFromDateString(
                        $dist . ' minutes'
                    );
                }

                $heuresFinSeance = $heureFinSeance->add($heurePlusTrajet);

                /** Termine le chemin si l'heure de fin est supérieur
                 * à la date de début de la prochain scéance.
                 */
                $heureDebutSeanceSuivante = new DateTimeImmutable(
                    $infosSeance['heureDebut']
                );

                if (
                    ($debutCircuit !== null && $heureDebutSeance < $heureDebut) ||
                    ($finCircuit !== null && $heureFinSeance < $heureFin) ||
                    (in_array($infosSeance['idFilm'], $listFilmVus, true)) ||
                    ($heuresFinSeance >= $heureDebutSeanceSuivante)
                ) {
                    continue;
                }

                $graph[$idSeance][] = $infosSeance;
            }

            $graph[$idSeance][] = $this->insertD();
        }

        return $graph;
    }

    /**
     * @return array<array<int, mixed>|string>
     */
    public function getGraph(): array
    {
        return $this->createCircuits($this->createFirstLine());
    }

    /**
     * @return array<string, int|string>
     */
    public function insertD(): array
    {
        return [
            'idSeance' => 0,
        ];
    }
    private function postFilter(): array
    {
        $post = filter_input_array(INPUT_POST, [
            'filmList' => [
                'filter' => FILTER_VALIDATE_INT,
                'flags'  => FILTER_REQUIRE_ARRAY,
            ],
            'salleList' => [
                'filter' => FILTER_VALIDATE_INT,
                'flags'  => FILTER_REQUIRE_ARRAY,
            ],
            'heureDebutMin' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'heureFinMax' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'minFilm' => [
                'filter' => FILTER_VALIDATE_INT,
                'options'   => ['min_range' => 1, 'max_range' => 10]
            ],
            'maxFilm' => [
                'filter' => FILTER_VALIDATE_INT,
                'options'   => ['min_range' => 1, 'max_range' => 10]
            ]
        ], true);

        $post['filmList'] = $post['filmList'] ?? [];
        $post['salleList'] = $post['salleList'] ?? [];
        $post['minFilm'] = $post['minFilm'] ?? 1;
        $post['maxFilm'] = $post['maxFilm'] ?? 10;

        return $post;
    }
}
