<?php

declare(strict_types=1);

namespace Exception\Class;

use Exception;

final class MethodNotExist extends Exception
{
    public function __construct(
        string $controller,
        string $action,
        string $message = '',
        int $code = 0,
        ?Exception $exception = null
    ) {
        $message = 'La méthode ' . $action .
            " n'existe pas dans le controleur " . $controller . '.';
        parent::__construct($message, $code, $exception);
    }
}
