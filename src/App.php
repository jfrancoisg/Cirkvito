<?php

declare(strict_types=1);

namespace App;

use PDO;

final class App
{
    public static function getConn(): PDO|null
    {
        return Connect::getInstance();
    }

    public static function getModel(string $nameModel): object
    {
        $classeName = '\\App\\Model\\' . ucfirst(strtolower($nameModel));

        return new $classeName(self::getConn());
    }

    public static function getClass(string $nameClass): object
    {
        $classeName = '\\App\\Class\\' . ucfirst(strtolower($nameClass));

        return new $classeName(self::getConn());
    }
}
