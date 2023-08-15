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

        if (!$constraint instanceof RoomDates) {
            throw new UnexpectedTypeException($constraint, RoomDates::class);
        }
        
        if($receipt->getDepartureLocation() == $receipt->getArrivalLocation()){
            $this->context->buildViolation($constraint->message)
                ->atPath('arrivalLocation')
                ->addViolation();
        }
    }
}