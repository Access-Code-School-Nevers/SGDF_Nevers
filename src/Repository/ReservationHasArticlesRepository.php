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

    // Insert articles of a specific reservation
    public function addArticlesToReservation($reservationId, $listArticles){
      $nbArticles = count($listArticles);
      $articlesToExecute = [];
      $hasArticlesToExecute = 0;

      if($nbArticles > 0 && is_int($reservationId)){
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'INSERT INTO reservation_has_articles VALUES ';
        for($i=0, $v=$nbArticles ; $i<$v ; $i++){
          $listArticles[$i] = intval($listArticles[$i]);
          if(is_int($listArticles[$i])){
            $sql .= '('.$reservationId.', :id'.$i.'),';
            $articlesToExecute['id'.$i] = $listArticles[$i];
            $hasArticlesToExecute++;
          }
        }

        if($hasArticlesToExecute > 0){
          $sql = substr($sql,0,-1);

          // PDO to escape values to avoid injections
          $stmt = $conn->prepare($sql);
          $stmt->execute($articlesToExecute);

          return true;
        }
        else return false;
      }
      else return false;
    }
}
