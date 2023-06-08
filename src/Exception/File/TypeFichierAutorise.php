<?php

declare(strict_types=1);

namespace Exception\File;

use App\Class\Logger;
use Exception;

final class TypeFichierAutorise extends Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Exception $previous = null
    ) {
        $message = 'Type de fichier non autorisé.';
        parent::__construct($message, $code, $previous);

        $logger = new Logger('exception');
        $logger->log('error', $message);
    }
}
