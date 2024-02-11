<?php

declare(strict_types=1);

namespace App\Model;

use App\Interface\Iget;
use PDO;

final class Film implements Iget
{
    public function __construct(
        private readonly PDO $pdo,
    ) {
    }

    /**
     * @return array<string>|false
     */
    public function getAll(): array|false
    {
        $sql = 'SELECT
                    f.id film,
                    f.titre,
                    f.duree
                FROM film f
                ORDER BY f.id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @return array<string>|false
     */
    public function getFilmsWithSeance(): array|false
    {
        $sql = 'SELECT 
                    f.id film,
                    f.titre,
                    f.duree
                FROM film f
                WHERE
                    f.id IN(
                    SELECT s.id_film
                    FROM seance s
                    WHERE s.id_film = f.id
                )
                ORDER BY f.id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @return array<string>
     */
    public function getList(): array|false
    {
        $sql = 'SELECT f.id, f.titre
                FROM film f
                ORDER BY f.titre';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    /**
     * @param int $idFilm Identifiant du film
     *
     * @return mixed
     */
    public function getById(int $idFilm): mixed
    {
        $sql = 'SELECT
                    f.id film,
                    f.titre,
                    f.duree
                FROM film f
                WHERE f.id = :idFilm
                ORDER BY f.id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':idFilm', $idFilm, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getnbFilm(): mixed
    {
        $sql = 'SELECT
                    count(*)
                FROM film f';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }
}
