<?php

namespace Viewpoint\ThemeBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Viewpoint\ThemeBundle\Entity\DepartureLocation;

/**
 * @extends ServiceEntityRepository<DepartureLocation>
 *
 * @method DepartureLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method DepartureLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method DepartureLocation[]    findAll()
 * @method DepartureLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartureLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepartureLocation::class);
    }
}