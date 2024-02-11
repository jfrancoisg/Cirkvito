<?php

declare(strict_types=1);

namespace App\Controller;

use App\App;

final class AdminController extends CoreController
{
    /** @var array<string, array<string>> $data Données des séances */
    private array $data = [];

    public function __construct()
    {
        $this->data['films'] = App::getModel('film')->getList();
        $this->data['salles'] = App::getModel('salle')->getList();
        $this->data['sections'] = App::getModel('section')->getList();
        $this->data['seances'] = App::getModel('seance')->getAll();
    }

    public function addSeance(): void
    {
        $this->render(
            'admin/addSeance',
            $this->data
        );
    }

    public function saveSeance(): void
    {
        $dateSeance = filter_input(INPUT_POST, 'dateSeance');
        $idSalle = (int) filter_input(INPUT_POST, 'idSalle');
        $idFilm = (int) filter_input(INPUT_POST, 'idFilm');
        $idSection = (int) filter_input(INPUT_POST, 'idSection');

        App::getModel('seance')->saveSeance($dateSeance, $idSalle, $idFilm, $idSection);

        $this->render(
            'admin/addSeance',
            $this->data
        );
    }
}
