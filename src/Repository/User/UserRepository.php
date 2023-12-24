<?php

namespace App\Repository\User;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findById(int $id): ?User
    {
        $query = $this->createQueryBuilder(User::TABLE)
            ->where(sprintf("%s.%s = :%s", User::TABLE, User::ID, User::ID))
            ->setParameter(User::ID, $id)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function create(array $data): User
    {
        $user = new User();
        $user->setFirstName($data[User::FIRST_NAME]);
        $user->setLastName($data[User::LAST_NAME]);
        $user->setSexe($data[User::SEXE]);
        $user->setBirth($data[User::BIRTH]);
        $user->setProfile($data[User::PROFILE]);
        $user->setUsername($data[User::USERNAME]);
        $user->setEmail($data[User::EMAIL]);
        $user->setPassword($data[User::PASSWORD]);
        $user->setIsVerified($data[User::IS_VERIFIED]);
        $user->setIsDeleted($data[User::IS_DELETED]);
        $user->setCreatedAt($data[User::CREATED_AT]);
        $user->setUpdatedAt($data[User::UPDATED_AT]);

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user;
    }
}
