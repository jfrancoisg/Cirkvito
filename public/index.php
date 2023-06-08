<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

$alexandre3 = [
    "in_the_rearview" => 1025,
    "the_lies_we_tell_ourselves" => 1300,
    "linda_veut_du_poulet" => 1516,
    "la_factory_des_cineastes" => 1723,
    "le_proces_goldman" => 2056,
    "tiger_stripes" => 2305,
];

$licorne = [
    "ama_gloria" => 1023,
    "le_regne_animal" => 1310,
    "le_proces_goldman" => 1556,
    "jeanne_du_barry" => 1826,
    "le_retour" => 2050,
    "monster" => 2335,
];

$raimu = [
    "le_proces_goldman" => 1156,
    "l_homme_le_plus_heureux_du_monde" => 1503,
    "matcha" => 1752,
    "ama_gloria" => 2023,
];

$studio13 = [
    "etat_limite" => 1312,
    "tiger_stripes" => 1635,
];

$plage = [
    "badlands" => 2303,
];

function trouverCircuits($graph)
{
    $circuits = [];

    function dfs($v, $chemin, $poids, $graph, &$circuits)
    {
        array_push($chemin, $v);
        foreach ($graph[$v] as $voisin) {
            $voisinSommet = $voisin['sommet'];
            $voisinPoids = $voisin['poids'];
            // dump($voisinSommet, $voisinPoids, $chemin[0]);
            if ($voisinSommet === $chemin[0] and $voisinSommet === 'd') {
                array_push(
                    $circuits,
                    [
                        'chemin' => array_merge(
                            $chemin,
                            [$voisinSommet]
                        ),
                        'poids' => $poids + $voisinPoids
                    ]
                );
            } elseif (!in_array($voisinSommet, $chemin)) {
                dfs($voisinSommet, $chemin, $poids + $voisinPoids, $graph, $circuits);
            }
        }
        array_pop($chemin);
    }

    foreach ($graph as $sommet => $voisins) {
        dfs($sommet, array(), 0, $graph, $circuits);
    }

    return $circuits;
}

// Exemple de graphe pondéré
$graph = [
    'd' => [
        ['sommet' => 'A', 'poids' => 23],
        ['sommet' => 'B', 'poids' => 23],
        ['sommet' => 'C', 'poids' => 23],
        ['sommet' => 'D', 'poids' => 17],
        ['sommet' => 'E', 'poids' => 23],
        ['sommet' => 'F', 'poids' => 17],
        ['sommet' => 'd', 'poids' => 0],
    ],
    'A' => [
        ['sommet' => 'B', 'poids' => 0],
        ['sommet' => 'C', 'poids' => 0],
        ['sommet' => 'D', 'poids' => 0],
        ['sommet' => 'F', 'poids' => 33],
        ['sommet' => 'd', 'poids' => 13],
    ],
    'B' => [
        ['sommet' => 'C', 'poids' => 0],
        ['sommet' => 'D', 'poids' => 0],
        ['sommet' => 'd', 'poids' => 13],
    ],
    'C' => [
        ['sommet' => 'D', 'poids' => 0],
        ['sommet' => 'd', 'poids' => 13],
    ],
    'D' => [
        ['sommet' => 'C', 'poids' => 0],
        ['sommet' => 'd', 'poids' => 13],
    ],
    'E' => [
        ['sommet' => 'B', 'poids' => 13],
        ['sommet' => 'C', 'poids' => 13],
        ['sommet' => 'D', 'poids' => 13],
        ['sommet' => 'F', 'poids' => 13],
        ['sommet' => 'd', 'poids' => 13],
    ],
    'F' => [
        ['sommet' => 'D', 'poids' => 13],
        ['sommet' => 'd', 'poids' => 13],
    ],
];

$circuits = trouverCircuits($graph);

var_dump($circuits);
