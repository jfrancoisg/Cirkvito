<?php

declare(strict_types=1);

namespace App\Controller;

use Twig\Extension\DebugExtension;
use Twig\Extra\Intl\IntlExtension;
use Twig\Extra\String\StringExtension;

abstract class CoreController
{
    public function index(): void
    {
        $this->render('index');
    }

    /**
     * @param array<string,array<string>> $data Données transmis au template
     */
    public function render(string $tpl, array $data = []): void
    {
        $filesystemLoader = new \Twig\Loader\FilesystemLoader('../templates');
        $twigEnvironment = new \Twig\Environment(
            $filesystemLoader,
            [
                'debug' => true,
            ]
        );
        $httpHost = filter_input(INPUT_SERVER, 'HTTP_HOST');
        $twigEnvironment->addGlobal('title', 'Cirkvito');
        $twigEnvironment->addGlobal('httpHost', $httpHost);

        $twigEnvironment->addExtension(new DebugExtension());
        $twigEnvironment->addExtension(new IntlExtension());
        $twigEnvironment->addExtension(new StringExtension());

        echo $twigEnvironment->render(
            $tpl . '.twig',
            $data
        );
    }

    /**
     * Erreur 404.
     */
    public function error404(): void
    {
        $this->render(
            'error404',
        );
    }
}
