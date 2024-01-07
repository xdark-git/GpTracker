<?php

namespace App\Repository\Role;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Role;


class RoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }

    public function findById(int $id): ?Role
    {
        $query = $this->createQueryBuilder(Role::TABLE)
            ->where(sprintf("%s.%s = :%s", Role::TABLE, Role::ID, Role::ID))
            ->setParameter(Role::ID, $id)
            ->setMaxResults(1)
            ->getQuery();

        return $query->getOneOrNullResult();
    }
}
