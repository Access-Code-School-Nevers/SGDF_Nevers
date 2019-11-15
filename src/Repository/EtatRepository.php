<?php

namespace App\Repository;

use App\Entity\Etat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Etat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etat[]    findAll()
 * @method Etat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etat::class);
    }

    // /**
    //  * @return Etat[] Returns an array of Etat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Etat
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // Update articles states that have changed
    public function changeStateOfArticles($listArticles){
      $listId = '';
      $tmpReq = '';

      // prepare the request to update values
      foreach($listArticles as $key => $state){
        if(is_int($key) && is_int($state)){
          $listId .= $key.',';
          $tmpReq .= ' WHEN '.$key.' THEN '.$state;
        }
      }

      $conn = $this->getEntityManager()->getConnection();

      $sql = "UPDATE etat
              SET etat = CASE article_id
                ".$tmpReq."
                ELSE etat
                END
              WHERE article_id IN(".substr($listId,0,-1).");";

      $stmt = $conn->prepare($sql);
      $stmt->execute();

      return true;
    }
}
