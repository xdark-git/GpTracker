<?php
namespace Viewpoint\AdminBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Viewpoint\AdminBundle\Entity\EmailVerificationAttempt;

/**
 * @extends ServiceEntityRepository<EmailVerificationAttempt>
 *
 * @method EmailVerificationAttempt|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmailVerificationAttempt|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmailVerificationAttempt[]    findAll()
 * @method EmailVerificationAttempt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmailVerificationAttemptRepository extends ServiceEntityRepository{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmailVerificationAttempt::class);
    }

    public function save(EmailVerificationAttempt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EmailVerificationAttempt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}