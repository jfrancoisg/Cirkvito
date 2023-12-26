<?php

declare(strict_types=1);

namespace App\Model;

use PDO;
use PDOException;

final class Import
{
    public function __construct(
        protected PDO $pdo,
    ) {
    }

    public function import(
        string $path,
        string $separator = ',',
        string $finLigne = ';'
    ): void {
        try {
            $sql = 'LOAD DATA INFILE :path
                    INTO TABLE nom_table
                    FIELDS TERMINATED BY :separator
                    LINES TERMINATED BY :finLigne
                    IGNORE 1 LINES'; // Ignore la première ligne si en-têtes

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':path', $path, PDO::PARAM_STR);
            $stmt->bindParam(':separator', $separator, PDO::PARAM_STR);
            $stmt->bindParam(':finLigne', $finLigne, PDO::PARAM_STR);

            $stmt->execute();
        } catch (PDOException $pdoException) {
            echo $pdoException->getMessage();
        }
    }
}
