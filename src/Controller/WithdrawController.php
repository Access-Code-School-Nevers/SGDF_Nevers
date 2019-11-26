<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;
use Symfony\Component\HttpFoundation\Request;

class WithdrawController extends AbstractController
{
  /**
  * @Route("/app/retrait", name="retrait")
  */
  public function retrait(Request $request)
  {
    // Get the first reservation id to be withdraw
    $idReservation = $this->getDoctrine()->getRepository(Reservation::class)->getFirstReservation($this->getUser()->getId());

    // If the user has a reservation
    if(isset($idReservation[0])){
      // Get all the articles reserved
      $articles = $this->getDoctrine()->getRepository(Reservation::class)->getReservationArticles($idReservation[0]['id'],1);

      // Parse articles to regroup them in visual
      $objectsByEmplacement = [];
      $firstEmplacement = 0; // Used to check if we get a value in POST after
      $hasPerishableOnly = 1; // Used to check if there's only perishable articles in reservation
      foreach($articles as $article){
        if($hasPerishableOnly == 1 && $article['perissable'] == 0)
          $hasPerishableOnly = 0;

        if($firstEmplacement == 0)
          $firstEmplacement = $article['emplacement_id'];

        if(!isset($objectsByEmplacement[$article['emplacement_id']]))
          $objectsByEmplacement[$article['emplacement_id']] = [];

        if(!isset($objectsByEmplacement[$article['emplacement_id']][$article['objet_id']])){
          $objectsByEmplacement[$article['emplacement_id']][$article['objet_id']]['titre'] = $article['titre'];
          $objectsByEmplacement[$article['emplacement_id']][$article['objet_id']]['listArticles'] = [];
        }

        array_push($objectsByEmplacement[$article['emplacement_id']][$article['objet_id']]['listArticles'],$article['article_id']);
      }
    }
    // Else we create empty variables
    else{
      $objectsByEmplacement = [];
      $firstEmplacement = 0;
    }

    // Handle request if user has completed the form
    if($request->request->get('codebar'.$firstEmplacement)){
      $hasFilledAll = 1;

      // Check if all barcodes inserted are correct with the values asked
      foreach($objectsByEmplacement as $key => $emplacement){
        if($request->request->get('codebar'.$key) && is_numeric(intval($request->request->get('codebar'.$key)))){
          if(intval($request->request->get('codebar'.$key)) != intval($key)){
            $hasFilledAll = 0;
            break;
          }
        }
        else{
          $hasFilledAll = 0;
          break;
        }
      }

      // Update status of reservation
      if($hasFilledAll == 1){
        if($hasPerishableOnly == 0)
          $this->getDoctrine()->getRepository(Reservation::class)->updateReservationStatus($idReservation[0]['id'],2);
        else
          $this->getDoctrine()->getRepository(Reservation::class)->updateReservationStatus($idReservation[0]['id'],3);

        // Success message
        $this->addFlash('success', 'Retrait enregistré !');
        return $this->redirectToRoute("home");
      }
      else{
        $this->addFlash('danger', 'Au moins un code-barres est incorrect.');
      }
    }


    return $this->render('scoot/retrait.html.twig', [
      'title' => 'retrait',
      'backUrl' => './home',
      'objectsByEmplacement' => $objectsByEmplacement,
      'hasPerishableOnly' => ((isset($hasPerishableOnly))?$hasPerishableOnly:''),
      'date_debut' => ((isset($idReservation[0]))?$idReservation[0]['date_debut']:''),
      'date_fin' => ((isset($idReservation[0]))?$idReservation[0]['date_fin']:'')
    ]);
  }
}
