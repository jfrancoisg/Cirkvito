<?php

declare(strict_types=1);

namespace App\Model;

use App\Interface\Iget;
use PDO;

final class Salle implements Iget
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
                    s.id salle,
                    s.nom
                FROM salle s
                ORDER BY s.id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * @return array<string>
     */
    public function getList(): array|false
    {
        $sql = 'SELECT s.id, s.nom
                FROM salle s
                JOIN seance sc ON sc.id_salle = s.id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    /**
     * @param int $idSalle Identifiant d'une salle
     *
     * @return mixed
     */
    public function getById(int $idSalle): mixed
    {
        $sql = 'SELECT
                    s.id salle,
                    s.nom
                FROM salle s
                WHERE s.id = :idSalle
                ORDER BY s.id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':idSalle', $idSalle, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }
}
