<?php

namespace Viewpoint\ThemeBundle\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class RoomLocations extends Constraint
{
    public string $message = "room_locations.same_location";

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
