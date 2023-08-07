<?php

namespace Viewpoint\ThemeBundle\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class RoomDates extends Constraint
{
    public string $messageDepartureInThePast = "La date de départ ne peut être dans le passé";
    public string $messageArrivalInOneMonth = 'La date d\'arrivée ne peut pas dépasser un mois compté d\'aujourd\'hui';
    public string $messageDepartureAfterArrival = 'la date de départ doit être avant la date d\'arrivée';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
