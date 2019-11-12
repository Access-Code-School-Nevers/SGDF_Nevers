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


  // Return all the available objects at a specified date with quantities
  // By getting : 1. all objects not in reservation, 2. objects that will be returned before the date of reservation starts
  public function getAvailablesObjets($date){
    $tmpDate = explode('-',$date);
    if(count($tmpDate) == 3 && checkDate($tmpDate[1],$tmpDate[2],$tmpDate[0])){
      $conn = $this->getEntityManager()->getConnection();

      $sql = "SELECT id, titre, sum(qty) as quantite
              FROM (
                  SELECT O.id, titre, count(*) as qty
                  FROM objet O
                  LEFT JOIN article A ON O.id = A.objet_id
                  LEFT JOIN reservation_has_articles RAS ON A.id = RAS.article_id
                  WHERE RAS.article_id IS NULL
                  GROUP BY O.id

                  UNION ALL

                  SELECT O.id, titre, count(*) as qty
                  FROM objet O
                  LEFT JOIN article A ON O.id = A.objet_id
                  LEFT JOIN reservation_has_articles RAS ON A.id = RAS.article_id
                  LEFT JOIN reservation R ON RAS.reservation_id = R.id
                  WHERE R.date_fin < :dateFin
                  AND O.perissable = 0
                  GROUP BY O.id
              	) t
              GROUP BY id";

      // PDO to escape values to avoid injections
      $stmt = $conn->prepare($sql);
      $stmt->execute(['dateFin' => $date]);

      // returns an array of arrays (i.e. a raw data set)
      return $stmt->fetchAll();
    }
    else return false;
  }
}
