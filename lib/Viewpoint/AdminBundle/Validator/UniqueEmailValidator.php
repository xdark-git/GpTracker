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

    public function validate($receipt, Constraint $constraint): void
    {
       
        if (!$receipt instanceof User) {
            throw new UnexpectedValueException($receipt, User::class);
        }

        if (!$constraint instanceof UniqueEmail) {
            throw new UnexpectedTypeException($constraint, UniqueEmail::class);
        }

        $email = $receipt->getEmail();
        
        $conditions = ["email" => $email, "isDeleted" => false];
        $user = $this->manager->getRepository(User::class)->findOneBy($conditions);
        
        if ($user && $user !== $receipt) {
            
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter("{{ string }}", $email)
                ->atPath('email')
                ->addViolation();
        }
    }
}
