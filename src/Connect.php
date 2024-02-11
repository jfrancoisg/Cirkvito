<?php

declare(strict_types=1);

namespace App;

use Dotenv\Dotenv;
use PDO;
use PDOException;

final class Connect
{
    private static PDO|null $pdo = null;

    private function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../public');
        $env = $dotenv->load();

        if (is_null(self::$pdo)) {
            try {
                // self::$pdo = new PDO('sqlite:../db/db.sqlite', null, null, [
                //     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                //     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                // ]);
                self::$pdo = new PDO(
                    'mysql:host=' . $env['DB_HOST'] . ';
                        dbname=' . $env['DB_BASE'] . '',
                    $env['DB_USER'],
                    $env['DB_PWD'],
                    [1002 => 'SET NAMES utf8']
                );
                self::$pdo->setAttribute(
                    PDO::ATTR_DEFAULT_FETCH_MODE,
                    PDO::FETCH_ASSOC
                );
                self::$pdo->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );
            } catch (PDOException $e) {
                echo 'Connexion impossible (erreur: ' . $e->getMessage() . ')';
            }
        }
    }

    public static function getInstance(): PDO|null
    {
        if (is_null(self::$pdo)) {
            new Connect();
        }

        return self::$pdo;
    }
}
