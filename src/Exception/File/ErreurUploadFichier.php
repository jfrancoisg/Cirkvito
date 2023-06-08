<?php

declare(strict_types=1);

namespace Exception\File;

use App\Class\Logger;
use Exception;

final class ErreurUploadFichier extends Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Exception $previous = null
    ) {
        $msg =
            ($message === '')
            ? 'Erreur lors de l\'upload du fichier.'
            : $message;
        parent::__construct($msg, $code, $previous);

        $logger = new Logger('exception');
        $logger->log('error', $msg);
    }
}
