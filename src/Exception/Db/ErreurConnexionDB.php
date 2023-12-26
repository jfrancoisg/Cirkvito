<?php

declare(strict_types=1);

namespace Exception\Db;

use Exception;

final class ErreurConnexionDB extends Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Exception $exception = null
    ) {
        $message = 'Erreur lors de la connexion.';
        parent::__construct($message, $code, $exception);
    }
}
