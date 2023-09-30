<?php

namespace Viewpoint\ThemeBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Viewpoint\ThemeBundle\Entity\Room;

class RoomDatesValidator extends ConstraintValidator
{
    public function validate($receipt, Constraint $constraint)
    {
      
        if (!$receipt instanceof Room) {
            throw new UnexpectedValueException($receipt, Room::class);
        }

        if (!$constraint instanceof RoomDates) {
            throw new UnexpectedTypeException($constraint, RoomDates::class);
        }
   
        // Validate the departure date not in the past
        $now = new \DateTime('today');
        if ($receipt->getDepartureDate() < $now) {
            $this->context->buildViolation($constraint->messageDepartureInThePast)
                ->atPath('departureDate')
                ->addViolation();
        }

        // Validate the arrival date is higher than one month from today
        $oneMonthFromNow = new \DateTime('today + 1 month');        

        if ($receipt->getArrivalDate()> $oneMonthFromNow) {
            $this->context->buildViolation($constraint->messageArrivalInOneMonth)
                ->atPath('arrivalDate')
                ->addViolation();
        }

        // Validate the departure date is before the arrival date
        if ($receipt->getArrivalDate() && ($receipt->getDepartureDate() >= $receipt->getArrivalDate())) {
            $this->context->buildViolation($constraint->messageDepartureAfterArrival)
                ->atPath('departureDate')
                ->addViolation();
        }
    }
}