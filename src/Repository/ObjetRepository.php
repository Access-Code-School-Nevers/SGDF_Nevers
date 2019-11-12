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

  /* FUNCTIONS TO GET AVAILABLE OBJECTS */
  // Return all the available objects at a specified date with quantity
  public function getAvailablesObjets($date){
    if(is_numeric($lg) && is_numeric($lat)){
      $rad = 50;
      $R = 6371;

      $maxLat = $lat + rad2deg($rad/$R);
      $minLat = $lat - rad2deg($rad/$R);
      $maxLon = $lg + rad2deg(asin($rad/$R) / cos(deg2rad($lat)));
      $minLon = $lg - rad2deg(asin($rad/$R) / cos(deg2rad($lat)));

      $conn = $this->getEntityManager()->getConnection();

      $sql = "SELECT structure.*, GROUP_CONCAT(distinct(type_handicap.nom)) AS types_handicap
              FROM structure
              LEFT JOIN handicap ON structure.id = handicap.structure_id_id
              LEFT JOIN type_handicap ON handicap.type_handicap_id_id = type_handicap.id
              WHERE Latitude BETWEEN :minLat AND :maxLat AND Longitude BETWEEN :minLon AND :maxLon
              GROUP BY structure.id";


      // PDO to escape values to avoid injections
      $stmt = $conn->prepare($sql);
      $stmt->execute(['minLon' => $minLon, 'maxLon' => $maxLon, 'minLat' => $minLat, 'maxLat' => $maxLat]);

      // returns an array of arrays (i.e. a raw data set)
      return $stmt->fetchAll();
    }
    else return false;
  }
}
