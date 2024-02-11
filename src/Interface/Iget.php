<?php

declare(strict_types=1);

namespace App\Interface;

interface Iget
{
    /**
     * @return array<string>|false
     */
    public function getAll(): array|false;

    /**
     * @return array<string>|false
     */
    public function getList(): array|false;

    /**
     * @return array<string>|false
     */
    public function getById(int $idSeance): mixed;
}
