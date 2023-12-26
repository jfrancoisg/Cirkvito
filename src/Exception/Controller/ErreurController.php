<?php

declare(strict_types=1);

namespace Exception\Controller;

use Exception;

final class ErreurController extends Exception
{
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Exception $exception = null
    ) {
        $message = 'Aucun controller trouvé.';
        parent::__construct($message, $code, $exception);
    }
}
