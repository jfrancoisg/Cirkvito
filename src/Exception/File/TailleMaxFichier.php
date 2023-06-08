<?php

declare(strict_types=1);

namespace Exception\File;

use App\Class\Logger;
use Exception;

final class TailleMaxFichier extends Exception
{
    public function __construct(
        protected int $fileSize,
        protected ?Exception $previous = null
    ) {
        $message = 'Le fichier est trop volumineux.
                    La taille maximale autorisée est ' .
            ($this->fileSize / 1048576) . ' Mo.';
        parent::__construct($message, $this->code, $this->previous);

        $logger = new Logger('exception');
        $logger->log('error', $message);
    }
}
