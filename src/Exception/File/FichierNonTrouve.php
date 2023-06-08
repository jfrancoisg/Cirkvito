<?php

declare(strict_types=1);

namespace Exception\File;

use App\Class\Logger;
use Exception;

final class FichierNonTrouve extends Exception
{
    protected string $maxFileSize;

    public function __construct(
        string $message = '',
        int $code = 0,
        ?Exception $previous = null
    ) {
        $message = 'Le fichier n\'a pas été trouvé.';
        parent::__construct($message, $code, $previous);

        $logger = new Logger('exception');
        $logger->log('error', $message);
    }
}
