<?php

namespace App\Repository;

use App\Entity\ReservationHasArticles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ReservationHasArticles|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationHasArticles|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationHasArticles[]    findAll()
 * @method ReservationHasArticles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationHasArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationHasArticles::class);
    }

    // /**
    //  * @return ReservationHasArticles[] Returns an array of ReservationHasArticles objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReservationHasArticles
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
