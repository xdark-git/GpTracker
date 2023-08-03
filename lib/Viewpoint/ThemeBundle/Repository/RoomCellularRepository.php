<?php

namespace Viewpoint\ThemeBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Viewpoint\ThemeBundle\Entity\RoomCellular;

/**
 * @extends ServiceEntityRepository<RoomCellular>
 *
 * @method RoomCellular|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoomCellular|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoomCellular[]    findAll()
 * @method RoomCellular[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomCellularRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoomCellular::class);
    }

    public function save(RoomCellular $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RoomCellular $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}