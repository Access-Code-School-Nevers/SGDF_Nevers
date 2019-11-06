<?php

namespace App\Repository;

use App\Entity\Peremption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Peremption|null find($id, $lockMode = null, $lockVersion = null)
 * @method Peremption|null findOneBy(array $criteria, array $orderBy = null)
 * @method Peremption[]    findAll()
 * @method Peremption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeremptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Peremption::class);
    }

    // /**
    //  * @return Peremption[] Returns an array of Peremption objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Peremption
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
