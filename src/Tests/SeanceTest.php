<?php

declare(strict_types=1);

namespace Tests;

use App\Controller\SeanceController;
use PHPUnit\Framework\TestCase;

class SeanceTest extends TestCase
{
    public function testGen()
    {
        // Créez une instance de votre classe
        $instance = new SeanceController();

        // Définissez des données de test
        $chemin = [/* vos données */];
        $suivant = ['idSeance' => '2'];

        // Appelez la méthode que vous testez
        $resultat = $instance->gen($chemin, $suivant);

        // Asserts pour vérifier les résultats
        $this->assertIsArray($resultat);
        $this->assertArrayHasKey('chemin', $resultat);
    }

    /**
     * Teste la méthode insertD()
     */
    public function testInsertD(): void
    {
        // Crée une instance de la classe contenant la méthode insertD()
        $instance = new SeanceController();

        // Appelle la méthode insertD()
        $resultat = $instance->insertD();

        // Définit le tableau attendu
        $tableauAttendu = [
            'idSeance' => 0,
        ];

        // Vérifie que le résultat de insertD() correspond au tableau attendu
        $this->assertEquals($tableauAttendu, $resultat);
    }
}
