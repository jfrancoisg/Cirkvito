<?php

declare(strict_types=1);

namespace Exception\Db;

use App\Class\Logger;
use Exception;

final class ErreurConnexionDB extends Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Exception $previous = null
    ) {
        $message = 'Erreur lors de la connexion.';
        parent::__construct($message, $code, $previous);

        $logger = new Logger('exception');
        $logger->log('critical', $message);
    }
}
