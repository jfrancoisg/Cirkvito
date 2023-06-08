<?php

declare(strict_types=1);

namespace Exception\File;

use App\Class\Logger;
use Exception;

final class LongueurLigneIncorrecte extends Exception
{
    public function __construct(
        int $i,
        string $r,
        int $nbLine,
        string $message = '',
        int $code = 0,
        ?Exception $previous = null
    ) {
        $message = 'La ligne ' . $i . ' comporte ' . $r
            . ' caractères au lieu de ' . $nbLine;
        parent::__construct($message, $code, $previous);

        $logger = new Logger('exception');
        $logger->log('error', $message);
    }
}
