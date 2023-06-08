<?php

declare(strict_types=1);

namespace Exception\Controller;

use App\Class\Logger;
use Exception;

final class ErreurController extends Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Exception $previous = null
    ) {
        $message = 'Aucun controller trouvé.';
        parent::__construct($message, $code, $previous);

        $logger = new Logger('exception');
        $logger->log('error', $message);
    }
}
