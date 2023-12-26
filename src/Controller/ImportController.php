<?php

declare(strict_types=1);

namespace App\Controller;

use App\App;

final class ImportController extends CoreController
{
    public function importCsv(string $path): void
    {
        $import = App::getModel('import');
        $import->import($path);
    }
}
