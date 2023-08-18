<?php

namespace Viewpoint\ThemeBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Viewpoint\ThemeBundle\Entity\Room;

class RoomLocationsValidator extends ConstraintValidator
{
    public function validate($receipt, Constraint $constraint)
    {
        if (!$receipt instanceof Room) {
            throw new UnexpectedValueException($receipt, Room::class);
        }

        if (!$constraint instanceof RoomLocations) {
            throw new UnexpectedTypeException($constraint, RoomDates::class);
        }
        
        if(!$receipt->getDepartureLocation()){
            $this->context
                ->buildViolation($constraint->messageCityNotFound)
                ->atPath("departureLocation")
                ->addViolation();
        }

        if(!$receipt->getArrivalLocation()){
            $this->context
                ->buildViolation($constraint->messageCityNotFound)
                ->atPath("arrivalLocation")
                ->addViolation();
        }

        if (
            $receipt->getDepartureLocation() &&
            $receipt->getArrivalLocation() &&
            $receipt->getDepartureLocation() == $receipt->getArrivalLocation()
        ) {
            $this->context
                ->buildViolation($constraint->messageSameLocation)
                ->atPath("arrivalLocation")
                ->addViolation();
        }
    }
}
