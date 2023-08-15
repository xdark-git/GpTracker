<?php

namespace Viewpoint\ThemeBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Viewpoint\ThemeBundle\Entity\ArrivalLocation;

/**
 * @extends ServiceEntityRepository<ArrivalLocation>
 *
 * @method ArrivalLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArrivalLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArrivalLocation[]    findAll()
 * @method ArrivalLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArrivalLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArrivalLocation::class);
    }
}