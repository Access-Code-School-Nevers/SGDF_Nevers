<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    // /**
    //  * @return Reservation[] Returns an array of Reservation objects
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
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    // Return the id of the next reservation to be withraw
    public function getFirstReservation($user){
      $conn = $this->getEntityManager()->getConnection();

      $sql = "SELECT id
              FROM reservation
              WHERE utilisateur_id = :user
              AND statut = 1
              ORDER BY date_debut ASC
              LIMIT 1";

      // PDO to escape values to avoid injections
      $stmt = $conn->prepare($sql);
      $stmt->execute(['user' => $user]);

      // returns an array of arrays (i.e. a raw data set)
      return $stmt->fetchAll();
    }


    // Return all the articles of a reservation for a specific user
    public function getReservationArticles($idReservation,$type){
      $conn = $this->getEntityManager()->getConnection();

      $sql = "SELECT O.id AS objet_id, O.titre, A.emplacement_id, A.id article_id
              FROM reservation R
              LEFT JOIN reservation_has_articles RAS ON R.id = RAS.reservation_id
              LEFT JOIN article A ON RAS.article_id = A.id
              LEFT JOIN objet O ON A.objet_id = O.id
              WHERE R.id = :idReservation
              AND R.statut = :type
              ORDER BY A.emplacement_id ASC";

      // PDO to escape values to avoid injections
      $stmt = $conn->prepare($sql);
      $stmt->execute(['idReservation' => $idReservation, 'type' => $type]);

      // returns an array of arrays (i.e. a raw data set)
      return $stmt->fetchAll();
    }


    // Update reservation of a specific user
    public function updateReservationStatus($idReservation,$status){
      $conn = $this->getEntityManager()->getConnection();

      $sql = "UPDATE reservation
              SET statut = :status
              WHERE id = :id";

      // PDO to escape values to avoid injections
      $stmt = $conn->prepare($sql);
      $stmt->execute(['status' => $status, 'id' => $idReservation]);

      return true;
    }
}
