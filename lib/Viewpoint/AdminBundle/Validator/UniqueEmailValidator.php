<?php

namespace Viewpoint\AdminBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Doctrine\ORM\EntityManagerInterface;
use Viewpoint\AdminBundle\Entity\User;

class UniqueEmailValidator extends ConstraintValidator
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function validate($value, Constraint $constraint): void
    {
       
        if (!$constraint instanceof UniqueEmail) {
            throw new UnexpectedTypeException($constraint, UniqueEmail::class);
        }
        if (null === $value || "" === $value) {
            return;
        }

        if (!is_string($value)) {
            // throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
            throw new UnexpectedValueException($value, "string");

            // separate multiple types using pipes
            // throw new UnexpectedValueException($value, 'string|int');
        }

        $conditions = ["email" => $value, "isDeleted" => false];
        $user = $this->manager->getRepository(User::class)->findBy($conditions);
        
        if ($user) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter("{{ string }}", $value)
                ->addViolation();
        }
    }
}
