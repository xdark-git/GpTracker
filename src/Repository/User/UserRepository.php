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
            ->andWhere(sprintf("%s.%s = :%s", User::TABLE, User::IS_DELETED, User::IS_DELETED))
            ->setParameter(User::ID, $id)
            ->setParameter(User::IS_DELETED, false)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findByUsernameOrEmail(string $usernameOrEmail): ?User
    {
        $query = $this->createQueryBuilder(User::TABLE)
            ->where(sprintf("%s.%s = :%s", User::TABLE, User::USERNAME, User::USERNAME))
            ->orWhere(sprintf("%s.%s = :%s", User::TABLE, User::EMAIL, User::EMAIL))
            ->andWhere(sprintf("%s.%s = :%s", User::TABLE, User::IS_DELETED, User::IS_DELETED))
            ->setParameter(User::IS_DELETED, false)
            ->setParameter(User::USERNAME, $usernameOrEmail)
            ->setParameter(User::EMAIL, $usernameOrEmail)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function getPaginated(int $page, int $limit): array
    {
        $query = $this->createQueryBuilder(User::TABLE)
            ->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit)
            ->getQuery();

        return $query->getResult();
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
