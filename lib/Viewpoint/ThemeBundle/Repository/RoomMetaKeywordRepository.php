<?php

namespace Viewpoint\ThemeBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use viewpoint\ThemeBundle\Entity\RoomMetaKeyword;
/**
 * @extends ServiceEntityRepository<RoomMetaKeyword>
 *
 * @method RoomMetaKeyword|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoomMetaKeyword|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoomMetaKeyword[]    findAll()
 * @method RoomMetaKeyword[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomMetaKeywordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoomMetaKeyword::class);
    }

    public function save(RoomMetaKeyword $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(RoomMetaKeyword $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
