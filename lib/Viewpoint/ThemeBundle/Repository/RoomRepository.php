<?php

namespace Viewpoint\ThemeBundle\Repository;

use Viewpoint\ThemeBundle\Entity\Room;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Viewpoint\ThemeBundle\Data\SearchData;
use Viewpoint\ThemeBundle\Entity\City;

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

    public function findAvailableRoomsQuery(
        ?SearchData $search = null,
        ?string $sortData = null
    ): Query {
        $currentDateTime = new \DateTime();

        $qb = $this->createQueryBuilder("r")
            ->andWhere("r.departureDate > :currentDateTime")
            ->andWhere("r.isDeleted = :isDeleted")
            ->innerJoin("r.user", "u") // Join with the user entity
            ->andWhere("u.isDeleted = :isUserDeleted")
            ->setParameter("currentDateTime", $currentDateTime)
            ->setParameter("isDeleted", false)
            ->setParameter("isUserDeleted", false)
            ->orderBy("r.departureDate", "ASC");

        if ($search) {
            if ($search->departureLocation) {
                $qb->andWhere(
                    "r.departureLocation IN (SELECT c.id FROM " .
                        City::class .
                        " c WHERE c.name LIKE :departureLocation)"
                )->setParameter("departureLocation", "%" . $search->departureLocation . "%");
            }

            if ($search->arrivalLocation) {
                $qb->andWhere(
                    "r.arrivalLocation IN (SELECT c.id FROM " .
                        City::class .
                        " c WHERE c.name LIKE :arrivalLocation)"
                )->setParameter("arrivalLocation", "%" . $search->arrivalLocation . "%");
            }

            if ($search->minDate) {
                $qb->andWhere("r.departureDate >= :minDate")->setParameter(
                    "minDate",
                    $search->minDate
                );
            }

            if ($search->maxDate) {
                $maxDate = $search->maxDate->setTime(23, 59, 59);
                $qb->andWhere("r.departureDate <= :maxDate")->setParameter("maxDate", $maxDate);
            }
        }

        if ($sortData === "cheaper") {
            $qb->orderBy("r.unitPrice", "ASC");
        } elseif ($sortData === "weight") {
            $qb->orderBy("r.weight", "DESC");
        }

        return $qb->getQuery();
    }

    public function findAvailableRoomForHomePage(int $limit = 3)
    {
        $currentDateTime = new \DateTime();

        return $this->createQueryBuilder("r")
            ->andWhere("r.departureDate > :currentDateTime")
            ->andWhere("r.isDeleted = :isDeleted")
            ->innerJoin("r.user", "u") // Join with the user entity
            ->andWhere("u.isDeleted = :isUserDeleted")
            ->setParameter("currentDateTime", $currentDateTime)
            ->setParameter("isDeleted", false)
            ->setParameter("isUserDeleted", false)
            ->orderBy("r.departureDate", "ASC")
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
