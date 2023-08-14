<?php

namespace Viewpoint\ThemeBundle\Repository;

use Viewpoint\ThemeBundle\Entity\Room;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Room>
 *
 * @method Room|null find($id, $lockMode = null, $lockVersion = null)
 * @method Room|null findOneBy(array $criteria, array $orderBy = null)
 * @method Room[]    findAll()
 * @method Room[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Room::class);
    }

    public function save(Room $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Room $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAvailableRoomsQuery():Query
    {
        $currentDateTime = new \DateTime();

        return $this->createQueryBuilder("r")
            ->andWhere("r.arrivalDate > :currentDateTime")
            ->andWhere("r.isDeleted = :isDeleted")
            ->innerJoin("r.user", "u") // Join with the user entity
            ->andWhere("u.isDeleted = :isUserDeleted")
            ->setParameter("currentDateTime", $currentDateTime)
            ->setParameter("isDeleted", false)
            ->setParameter("isUserDeleted", false)
            ->orderBy('r.createdAt', 'DESC') 
            ->getQuery();
    }
}
