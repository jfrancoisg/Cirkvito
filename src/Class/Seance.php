<?php

declare(strict_types=1);

namespace App\Class;

final class Seance
{
    public function __construct(
        private Film $film,
        private Salle $salle,
        private Section $section
    ) {
        $this->film = new Film();
        $this->salle = new Salle();
        $this->section = new Section();
    }
}
