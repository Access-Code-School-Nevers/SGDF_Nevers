<?php

namespace App\Repository;

use App\Entity\CreerObjet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CreerObjet|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreerObjet|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreerObjet[]    findAll()
 * @method CreerObjet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreerObjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreerObjet::class);
    }

    // /**
    //  * @return CreerObjet[] Returns an array of CreerObjet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CreerObjet
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
