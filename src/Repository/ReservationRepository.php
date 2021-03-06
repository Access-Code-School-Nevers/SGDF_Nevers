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

    // Return the number of reservation of statut 1 and 2
    public function getNumberOfReservation($user){
      $reservations = [];
      $conn = $this->getEntityManager()->getConnection();

      $sql = "SELECT statut, count(*) AS number_reservation
              FROM reservation
              WHERE utilisateur_id = :user
              AND (statut = 1 OR statut = 2)
              GROUP BY statut";

      $stmt = $conn->prepare($sql);
      $stmt->execute(['user' => $user]);

      while($row = $stmt->fetch()){
        if($row['statut'] == 1) $reservations['reservation'] = $row['number_reservation'];
        else $reservations['emprunt'] = $row['number_reservation'];
      }

      return $reservations;
    }

    // Return the id of the next reservation to be withraw
    public function getFirstReservation($user){
      $conn = $this->getEntityManager()->getConnection();

      $sql = "SELECT id, date_debut, date_fin
              FROM reservation
              WHERE utilisateur_id = :user
              AND statut = 1
              ORDER BY date_debut ASC
              LIMIT 1";

      $stmt = $conn->prepare($sql);
      $stmt->execute(['user' => $user]);

      return $stmt->fetchAll();
    }


    // Return all the articles of a reservation for a specific user
    public function getReservationArticles($idReservation,$type){
      $conn = $this->getEntityManager()->getConnection();

      $sql = "SELECT O.id AS objet_id, O.titre, A.emplacement_id, A.id AS article_id, O.perissable
              FROM reservation R
              LEFT JOIN reservation_has_articles RAS ON R.id = RAS.reservation_id
              LEFT JOIN article A ON RAS.article_id = A.id
              LEFT JOIN objet O ON A.objet_id = O.id
              WHERE R.id = :idReservation
              AND R.statut = :type
              ORDER BY A.emplacement_id ASC";

      $stmt = $conn->prepare($sql);
      $stmt->execute(['idReservation' => $idReservation, 'type' => $type]);

      return $stmt->fetchAll();
    }


    // Update reservation of a specific user
    public function updateReservationStatus($idReservation,$status){
      $conn = $this->getEntityManager()->getConnection();

      $sql = "UPDATE reservation
              SET statut = :status
              WHERE id = :id";

      $stmt = $conn->prepare($sql);
      $stmt->execute(['status' => $status, 'id' => $idReservation]);

      return true;
    }

    // Return all historical of a user
    public function getHistorical($user){
      $conn = $this->getEntityManager()->getConnection();

      $sql = "SELECT R.id AS reservation_id, R.date_debut, R.date_fin, O.titre, A.emplacement_id, A.id AS article_id
              FROM reservation R
              LEFT JOIN reservation_has_articles RAS ON R.id = RAS.reservation_id
              LEFT JOIN article A ON RAS.article_id = A.id
              LEFT JOIN objet O ON A.objet_id = O.id
              WHERE R.utilisateur_id = :user
              AND R.statut = 3
              ORDER BY R.id ASC, A.emplacement_id ASC, O.id ASC";

      $stmt = $conn->prepare($sql);
      $stmt->execute(['user' => $user]);

      return $stmt->fetchAll();
    }


    // Return the id of the next restitution
    public function getFirstRestitution($user){
      $conn = $this->getEntityManager()->getConnection();

      $sql = "SELECT id, date_debut, date_fin
              FROM reservation
              WHERE utilisateur_id = :user
              AND statut = 2
              ORDER BY date_debut ASC
              LIMIT 1";

      $stmt = $conn->prepare($sql);
      $stmt->execute(['user' => $user]);

      return $stmt->fetchAll();
    }

    // Return all the articles of a restitution for a specific user
    public function getRestitutionArticles($idReservation,$type){
      $conn = $this->getEntityManager()->getConnection();

      $sql = "SELECT O.id AS objet_id, O.titre, A.emplacement_id, A.id AS article_id, E.etat
              FROM reservation R
              LEFT JOIN reservation_has_articles RAS ON R.id = RAS.reservation_id
              LEFT JOIN article A ON RAS.article_id = A.id
              LEFT JOIN objet O ON A.objet_id = O.id
              LEFT JOIN etat E ON A.id = E.article_id
              WHERE R.id = :idReservation
              AND R.statut = :type
              AND E.etat != 'null'
              ORDER BY A.emplacement_id ASC";

      $stmt = $conn->prepare($sql);
      $stmt->execute(['idReservation' => $idReservation, 'type' => $type]);

      return $stmt->fetchAll();
    }
}
