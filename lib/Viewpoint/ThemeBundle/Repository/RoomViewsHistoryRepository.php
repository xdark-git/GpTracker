<?php

namespace Viewpoint\ThemeBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Viewpoint\AdminBundle\Entity\User;
use Viewpoint\ThemeBundle\Entity\RoomViewsHistory;

/**
 * @extends ServiceEntityRepository<RoomViewsHistory>
 */
class RoomViewsHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoomViewsHistory::class);
    }

    public function save(RoomViewsHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RoomViewsHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findVisitedRoomsByCurrentUser(User $user): Query
    {
        return $this->createQueryBuilder("rh")
            ->innerJoin("rh.user", "u")
            ->innerJoin("rh.room", "r")
            ->andWhere("u = :user")
            ->andWhere("u.isDeleted = :isUserDeleted")
            ->andWhere("r.isDeleted = :isRoomDeleted")
            ->orderBy("rh.lastTimeVisited", "DESC")
            ->setParameter("user", $user)
            ->setParameter("isUserDeleted", false)
            ->setParameter("isRoomDeleted", false)
            ->getQuery();
    }
}
