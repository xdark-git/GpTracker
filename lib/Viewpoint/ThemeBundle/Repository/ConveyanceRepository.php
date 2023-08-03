<?php

namespace Viewpoint\ThemeBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Viewpoint\ThemeBundle\Entity\Conveyance;

/**
 * @extends ServiceEntityRepository<Conveyance>
 *
 * @method Conveyance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conveyance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conveyance[]    findAll()
 * @method Conveyance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConveyanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conveyance::class);
    }

    public function save(Conveyance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Conveyance $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}