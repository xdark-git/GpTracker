<?php

namespace Viewpoint\ThemeBundle\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class RoomLocations extends Constraint
{
    public string $messageSameLocation = "La ville de départ et d'arrivée ne peuvent pas être les mêmes.";
    public string $messageCityNotFound = "Ville introuvable. Veuillez choisir une ville valide.";

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
