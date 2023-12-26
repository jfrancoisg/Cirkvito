<?php

declare(strict_types=1);

namespace App;

final class App
{
    public static function getModel(string $nameModel): object
    {
        $modelName = '\\App\\Model\\' . ucfirst(strtolower($nameModel));

        return new $modelName();
    }
}
