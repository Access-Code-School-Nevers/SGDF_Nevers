<?php

namespace App\DataFixtures;

use App\Entity\Objet;
use App\Entity\Site;
use App\Entity\Emplacement;
use App\Entity\Article;
use App\Entity\Etat;
use App\Entity\Peremption;
use App\Entity\Utilisateur;
use App\Entity\Reservation;
use App\Entity\ReservationHasArticles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurFixture extends Fixture
{
  private $passwordEncoder;

  public function __construct(UserPasswordEncoderInterface $passwordEncoder){
    $this->passwordEncoder = $passwordEncoder;
  }

  public function load(ObjectManager $manager)
  {
    // Objets
    $objet[1] = new Objet();
    $objet[1]->setTitre('Pelle');
    $objet[1]->setDescription('Une pelle à manche rouge.');
    $objet[1]->setPcb(1);
    $objet[1]->setPerissable(0);
    $manager->persist($objet[1]);
    $manager->flush();

    $objet[2] = new Objet();
    $objet[2]->setTitre('Tente');
    $objet[2]->setDescription('Une tente 3 places.');
    $objet[2]->setPcb(1);
    $objet[2]->setPerissable(0);
    $manager->persist($objet[2]);
    $manager->flush();

    $objet[3] = new Objet();
    $objet[3]->setTitre('Pringles');
    $objet[3]->setDescription('Paquet de pringles.');
    $objet[3]->setPcb(1);
    $objet[3]->setPerissable(1);
    $manager->persist($objet[3]);
    $manager->flush();

    $objet[4] = new Objet();
    $objet[4]->setTitre('Pack d\'eau');
    $objet[4]->setDescription('Pack de 6 bouteilles d\'eau de 1.5 litres.');
    $objet[4]->setPcb(6);
    $objet[4]->setPerissable(1);
    $manager->persist($objet[4]);
    $manager->flush();


    // Site
    $site[1] = new Site(); // Id = 1
    $site[1]->setDescription("Nevers");
    $manager->persist($site[1]);
    $manager->flush();

    // Emplacement
    for($i=1 ; $i<5 ; $i++){ // Id = 1 à 4
      $emplacement[$i] = new Emplacement();
      $emplacement[$i]->setSite($site[1]);
      $manager->persist($emplacement[$i]);
      $manager->flush();
    }

    // Article
    for($i=1 ; $i<11 ; $i++){ // Id = 1 à 10
      $article[$i] = new Article();
      $article[$i]->setObjet($objet[1]); // -> Pelle à manche rouge
      $article[$i]->setEmplacement($emplacement[1]);
      $manager->persist($article[$i]);
      $manager->flush();
    }

    $article[11] = new Article(); // Id = 11
    $article[11]->setObjet($objet[2]); // -> Tente
    $article[11]->setEmplacement($emplacement[2]);
    $manager->persist($article[11]);
    $manager->flush();

    for($i=12 ; $i<17 ; $i++){
      $article[$i] = new Article(); // Id = 12 à 16
      $article[$i]->setObjet($objet[3]); // -> pringles
      $article[$i]->setEmplacement($emplacement[3]);
      $manager->persist($article[$i]);
      $manager->flush();
    }

    for($i=17 ; $i<20 ; $i++){
      $article[$i] = new Article(); // Id = 17 à 19
      $article[$i]->setObjet($objet[4]); // -> pack d'eau
      $article[$i]->setEmplacement($emplacement[4]);
      $manager->persist($article[$i]);
      $manager->flush();
    }

    // Etat
    for($i=1 ; $i<11 ; $i++){
      $etat[$i] = new Etat();
      $etat[$i]->setArticle($article[$i]); // -> Pelle à manche rouge 1
      $etat[$i]->setEtat(5);
      $manager->persist($etat[$i]);
      $manager->flush();
    }

    $etat[11] = new Etat();
    $etat[11]->setArticle($article[11]); // -> Pelle à manche rouge 2
    $etat[11]->setEtat(5);
    $manager->persist($etat[11]);
    $manager->flush();

    // Peremption
    // -> Pringles (12 à 16) && Bouteilles d'eau (17 à 19)
    for($i=12 ; $i<20 ; $i++){
      $peremption[$i] = new Peremption();
      $peremption[$i]->setArticle($article[$i]);
      $peremption[$i]->setDatePeremption(new \DateTime('02/05/2020'));
      $peremption[$i]->setArchive(0);
      $manager->persist($peremption[$i]);
      $manager->flush();
    }

    // Utilisateurs
    $user[1] = new Utilisateur();
    $user[1]->setNom('admin');
    $user[1]->setPassword($this->passwordEncoder->encodePassword(
      $user[1], '123'
    ));
    $user[1]->setRole(1);
    $manager->persist($user[1]);

    $user[2] = new Utilisateur();
    $user[2]->setNom('responsable');
    $user[2]->setPassword($this->passwordEncoder->encodePassword(
      $user[2], '123'
    ));
    $user[2]->setRole(2);
    $manager->persist($user[2]);

    $user[3] = new Utilisateur();
    $user[3]->setNom('chef');
    $user[3]->setPassword($this->passwordEncoder->encodePassword(
      $user[3], '123'
    ));
    $user[3]->setRole(3);
    $manager->persist($user[3]);

    $manager->flush();


    // Reservation
    $reservation[1] = new Reservation();
    $reservation[1]->setUtilisateur($user[1]);
    $reservation[1]->setDateDebut(new \DateTime('11/10/2019'));
    $reservation[1]->setDateFin(new \DateTime('11/20/2019'));
    $reservation[1]->setStatut(1);
    $manager->persist($reservation[1]);
    $manager->flush();

    // Reservation has articles
    $reservationHasArticles[1] = new ReservationHasArticles();
    $reservationHasArticles[1]->setReservation($reservation[1]);
    $reservationHasArticles[1]->setArticle($article[1]);
    $manager->persist($reservationHasArticles[1]);
    $manager->flush();

    $reservationHasArticles[2] = new ReservationHasArticles();
    $reservationHasArticles[2]->setReservation($reservation[1]);
    $reservationHasArticles[2]->setArticle($article[2]);
    $manager->persist($reservationHasArticles[2]);
    $manager->flush();

    $reservationHasArticles[3] = new ReservationHasArticles();
    $reservationHasArticles[3]->setReservation($reservation[1]);
    $reservationHasArticles[3]->setArticle($article[12]);
    $manager->persist($reservationHasArticles[3]);
    $manager->flush();
  }
}
