<?php

namespace App\Repository;

use App\Entity\Objet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\RegistryInterface;


/**
 * @method Objet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Objet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Objet[]    findAll()
 * @method Objet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Objet::class);
    }

    /**
      * @return  Objet[] Returns an array of Objet objects
    */


  /*  public function findByExampleField($value)

    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
        //    ->orderBy('o.id', 'ASC')
        //    ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
*/

//autre methode
public function findByName($value)
{
    return $this->createQueryBuilder('c')
        ->andWhere('c.title like :query')
        ->setParameter('query', "%". $value ."%")
        // ->orderBy('c.id', 'ASC')
        // ->setMaxResults(10)
        ->getQuery()
        ->getResult()
    ;
}
// fin autre methode
    /*
    public function findOneBySomeField($value): ?Objet
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
