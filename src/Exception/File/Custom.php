<?php

declare(strict_types=1);

namespace Exception\File;

use App\Class\Logger;
use Exception;

final class Custom extends Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $logger = new Logger('debug');
        $logger->log('error', $message);
    }
}
