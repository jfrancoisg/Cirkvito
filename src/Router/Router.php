<?php

/**
 * Router.
 *
 * PHP version 8.2
 *
 * @category Interfaces
 *
 * @package Router
 *
 * @author JFG <gourdain.jf@mipih.fr>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @link www.mipih.fr
 */

declare(strict_types=1);

namespace App\Router;

use Exception\Class\MethodNotExist;
use Exception\Controller\ErreurController;

/**
 * Router.
 *
 * @category Interfaces
 *
 * @package Router
 *
 * @author JFG <gourdain.jf@mipih.fr>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @link www.mipih.fr
 */
final class Router
{
    /**
     * Constructeur du router.
     */
    public function __construct(
        private string $ctrl = '',
        private string $action = '',
        private string $param = ''
    ) {
    }

    /**
     * Démarre l'application.
     */
    public function run(): void
    {
        if (filter_input(INPUT_GET, 'controller') !== null) {
            $this->ctrl =
                ucfirst((string) filter_input(INPUT_GET, 'controller'));

            $this->action = filter_input(INPUT_GET, 'action') !== null
                ? (string) filter_input(INPUT_GET, 'action')
                : 'index';

            $param = filter_input(INPUT_GET, 'param');

            if ($param === null) {
                $this->param = (string) filter_input(INPUT_GET, 'param');
            }

            if ($this->ctrl !== '' && $this->action !== '') {
                $ctrl = '\\App\\Controller\\' . $this->ctrl . 'Controller';
                $controller = new $ctrl();

                $this->methodExist($controller, (string) $this->action);
            } else {
                $this->indexInterface('interface');
            }
        } else {
            throw new ErreurController();
        }
    }

    /**
     * Vérifie si la méthode existe dans un controlleur.
     *
     * @param object $controller Controlleur
     * @param string $action     Action a vérifiée
     */
    private function methodExist(object $controller, string $action): void
    {
        if (method_exists($controller, $action)) {
            $this->param !== '' ?
                $controller->$action($this->param) :
                $controller->$action();
        } else {
            throw new MethodNotExist($this->ctrl, $action);
        }
    }

    private function indexInterface(string $nomInterface): void
    {
        $nameController =
            '\\App\\Controller\\' . $nomInterface . 'Controller';
        $controller = new $nameController();
        $controller->index();
    }
}
