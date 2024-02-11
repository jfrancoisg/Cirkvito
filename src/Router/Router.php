<?php

declare(strict_types=1);

namespace App\Router;

use Exception\Class\MethodNotExist;
use Exception\Controller\ErreurController;

final class Router
{
    public function __construct(
        private string $ctrl = '',
        private string $action = '',
        private string $param = ''
    ) {
    }

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

                $this->methodExist($controller, $this->action);
            } else {
                $this->index('seance');
            }
        } else {
            throw new ErreurController();
        }
    }

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

    private function index(string $nomInterface): void
    {
        $nameController =
            '\\App\\Controller\\' . $nomInterface . 'Controller';
        $controller = new $nameController();
        $controller->index();
    }
}
