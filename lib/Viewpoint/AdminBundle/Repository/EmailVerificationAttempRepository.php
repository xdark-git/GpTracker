<?php
namespace Viewpoint\AdminBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Viewpoint\AdminBundle\Entity\EmailVerificationAttemp;

/**
 * @extends ServiceEntityRepository<EmailVerificationAttemp>
 *
 * @method EmailVerificationAttemp|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailVerificationAttemp|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailVerificationAttemp[]    findAll()
 * @method EmailVerificationAttemp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailVerificationAttempRepository extends ServiceEntityRepository{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailVerificationAttemp::class);
    }

    public function save(EmailVerificationAttemp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EmailVerificationAttemp $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}