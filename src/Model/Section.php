<?php

declare(strict_types=1);

namespace App\Model;

use App\Interface\Iget;
use PDO;

final class Section implements Iget
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
                    s.id section,
                    s.nom
                FROM section s
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
                FROM section s
                JOIN seance sc ON sc.id_section = s.id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    /**
     * @param int $idSection Identifiant d'une section
     *
     * @return mixed
     */
    public function getById(int $idSection): mixed
    {
        $sql = 'SELECT
                    s.id section,
                    s.nom
                FROM section s
                WHERE s.id = :idSection
                ORDER BY s.id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':idSection', $idSection, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }
}
