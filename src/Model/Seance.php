<?php

declare(strict_types=1);

namespace App\Model;

use App\Interface\Iget;
use PDO;
use PDOException;

final class Seance implements Iget
{
    public function __construct(
        private readonly PDO $pdo,
    ) {
    }

    /**
     * @param ?array $filmList Liste des films à exlure du circuit
     * @param ?array $salleList Liste des salles à exclure dans le circuit
     *
     * @return array<string>
     */
    public function getAllWithFilters(
        array $post,
    ): array|false {
        try {
            $filmList = ($post['filmList'] !== []) ? $post['filmList'] : [0 => '0'];
            $salleList = ($post['salleList'] !== []) ? $post['salleList'] : [0 => '0'];

            $sql = 'SELECT
                    s.id idSeance,
                    f.id idFilm,
                    sa.id idSalle,
                    sa.nom nomSalle,
                    s.heure_debut heureDebut,
                    DATE_ADD(s.heure_debut, INTERVAL(f.duree) MINUTE) heureFin
                FROM seance s
                JOIN film f ON f.id = s.id_film
                JOIN salle sa ON sa.id = s.id_salle
                JOIN section se ON se.id = s.id_section
                WHERE s.heure_debut > :heureDebutMin
                AND DATE_ADD(s.heure_debut, INTERVAL(f.duree) MINUTE) < :heureFinMax
                AND f.id NOT IN (' . implode(",", $filmList) . ')
                AND sa.id NOT IN (' . implode(",", $salleList) . ')
                ORDER BY s.heure_debut ASC';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':heureDebutMin', $post['heureDebutMin'], PDO::PARAM_STR);
            $stmt->bindParam(':heureFinMax', $post['heureFinMax'], PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @return array<string>
     */
    public function getList(): array|false
    {
        try {
            $sql = "SELECT
                    s.id,
                    concat(f.titre, '(', sa.nom, ', ', se.nom , ')') nom
                FROM seance s
                JOIN film f ON f.id = s.id_film
                JOIN salle sa ON sa.id = s.id_salle
                JOIN section se ON se.id = s.id_section
                ORDER BY nom";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function distBetween2Point(int $idsd, int $idsa): int
    {
        try {
            $sql = 'SELECT d.temps
                FROM distances d
                WHERE d.id_salle_depart = :idsd 
                AND d.id_salle_arrivee = :idsa';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idsa', $idsa, PDO::PARAM_INT);
            $stmt->bindParam(':idsd', $idsd, PDO::PARAM_INT);
            $stmt->execute();

            return (int) $stmt->fetchcolumn();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @param int $idSeance Identifiant de la séance
     *
     * @return mixed
     */
    public function getById(int $idSeance): mixed
    {
        try {
            $sql = 'SELECT
                    s.id idSeance,
                    f.id idfilm,
                    s.id idSalle,
                    sa.nom nomSalle,
                    f.duree,
                    f.titre,
                    s.heure_debut heureDebut,
                    DATE_ADD(s.heure_debut, INTERVAL(f.duree) MINUTE) heureFin
                FROM seance s
                JOIN film f ON f.id = s.id_film
                JOIN salle sa ON sa.id = s.id_salle
                JOIN section se ON se.id = s.id_section
                WHERE s.id = :idSeance';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':idSeance', $idSeance, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $stmt->fetch();
    }

    /**
     * @return array<string>
     */
    public function getAll(): array|false
    {
        try {
            $sql = 'SELECT
                    s.id idSeance,
                    sa.nom nomSalle,
                    f.duree,
                    f.titre,
                    s.heure_debut heureDebut
                FROM seance s
                JOIN film f ON f.id = s.id_film
                JOIN salle sa ON sa.id = s.id_salle
                JOIN section se ON se.id = s.id_section
                ORDER BY s.heure_debut DESC';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function saveSeance(string $dateSeance, int $idSalle, int $idFilm, int $idSection): void
    {
        try {
            $sql = 'INSERT INTO seance
                (heure_debut, id_salle, id_film, id_section) 
                VALUES
                (:dateSeance, :idSalle, :idFilm, :idSection)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':dateSeance', $dateSeance, PDO::PARAM_STR);
            $stmt->bindParam(':idSalle', $idSalle, PDO::PARAM_INT);
            $stmt->bindParam(':idFilm', $idFilm, PDO::PARAM_INT);
            $stmt->bindParam(':idSection', $idSection, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
