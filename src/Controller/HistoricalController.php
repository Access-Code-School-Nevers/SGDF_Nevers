<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;

class HistoricalController extends AbstractController
{
    /**
    * @Route("/app/historique", name="historique")
    */
    public function historique()
    {
      // Getting all articles of all historical reservations
      $listReservations = [];
      $tmpNbArticles = 0;
      $articles = $this->getDoctrine()->getRepository(Reservation::class)->getHistorical($this->getUser()->getId());

      // Sorting articles by reservations
      for($i=0, $v=count($articles) ; $i<$v ; $i++){
        if(!isset($listReservations[$articles[$i]['reservation_id']])){
          $listReservations[$articles[$i]['reservation_id']] = [];
          $listReservations[$articles[$i]['reservation_id']]['articles'] = [];
          $listReservations[$articles[$i]['reservation_id']]['dateDebut'] = $articles[$i]['date_debut'];
          $listReservations[$articles[$i]['reservation_id']]['dateFin'] = $articles[$i]['date_fin'];
          $tmpNbArticles = 0;
        }

        $listReservations[$articles[$i]['reservation_id']]['articles'][$tmpNbArticles]['titre'] = $articles[$i]['titre'];
        $listReservations[$articles[$i]['reservation_id']]['articles'][$tmpNbArticles]['emplacement'] = $articles[$i]['emplacement_id'];
        $listReservations[$articles[$i]['reservation_id']]['articles'][$tmpNbArticles]['article'] = $articles[$i]['article_id'];

        $tmpNbArticles++;
      }

      return $this->render('scoot/historique.html.twig', [
        'title' => 'Historique',
        'backUrl' => './home',
        'listReservations' => $listReservations
      ]);
    }
}
