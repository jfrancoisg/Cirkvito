<?php

/**
 * Factory.
 *
 * PHP version 8.2
 *
 * @category Factory
 *
 * @package Factory
 *
 * @author JFG <gourdain.jf@mipih.fr>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @link www.mipih.fr
 */

declare(strict_types=1);

namespace App;

/**
 * Factory.
 *
 * @category Factory
 *
 * @package Factory
 *
 * @author JFG <gourdain.jf@mipih.fr>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @link www.mipih.fr
 */
final class App
{
    /**
     * Instancie une classe.
     *
     * @param string $nameClass Nom de la classe à instancier
     */
    public static function getClass(string $nameClass): object
    {
        $classeName = '\\App\\Class\\' . ucfirst(strtolower($nameClass));

        return new $classeName();
    }
}
