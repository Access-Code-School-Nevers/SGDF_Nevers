<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;
use App\Entity\Etat;
use Symfony\Component\HttpFoundation\Request;

class RestitutionController extends AbstractController
{
  /**
  * @Route("/app/restituer", name="restituer")
  */
  public function restituer(Request $request)
  {
    // Get the first reservation id to be withdraw
    $idReservation = $this->getDoctrine()->getRepository(Reservation::class)->getFirstRestitution($this->getUser()->getId());

    // If the user has a reservation
    if(isset($idReservation[0])){
      // Get all the articles reserved
      $articles = $this->getDoctrine()->getRepository(Reservation::class)->getRestitutionArticles($idReservation[0]['id'],2);

      // Parse articles to regroup them in visual
      $objectsByEmplacement = [];
      $firstEmplacement = 0; // Used to check if we get a value in POST after
      $listArticlesId = [];
      foreach($articles as $article){
        if($firstEmplacement == 0)
          $firstEmplacement = $article['emplacement_id'];

        if(!isset($objectsByEmplacement[$article['emplacement_id']]))
          $objectsByEmplacement[$article['emplacement_id']] = [];

        if(!isset($objectsByEmplacement[$article['emplacement_id']][$article['objet_id']])){
          $objectsByEmplacement[$article['emplacement_id']][$article['objet_id']]['titre'] = $article['titre'];
          $objectsByEmplacement[$article['emplacement_id']][$article['objet_id']]['listArticles'] = [];
        }

        array_push($objectsByEmplacement[$article['emplacement_id']][$article['objet_id']]['listArticles'],
          [
            'id' => $article['article_id'],
            'etat' => $this->getStringStatus($article['etat'])
          ]);

        $listArticlesId[$article['article_id']] = $article['etat'];
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

      if($hasFilledAll == 1){
        $changeState = [];

        // Verify states of all articles
        foreach($listArticlesId as $key => $etatArticle){
          if($request->request->get('newState'.$key) && intval($request->request->get('newState'.$key)) > 0){
            if(intval($request->request->get('newState'.$key)) != $etatArticle){
              $changeState[$key] = intval($request->request->get('newState'.$key));
            }
          }
        }

        // Change reservation state
        $this->getDoctrine()->getRepository(Reservation::class)->updateReservationStatus($idReservation[0]['id'],3);

        // Change articles state
        if(count($changeState) > 0){
          $this->getDoctrine()->getRepository(Etat::class)->changeStateOfArticles($changeState);
        }

        // // Success message
        $this->addFlash('success', 'Restitution enregistrée !');
        return $this->redirectToRoute("home");
      }
      else{
        $this->addFlash('danger', 'Au moins un code-barres est incorrect.');
      }
    }

    return $this->render('scoot/restituer.html.twig', [
      'title' => 'Restituer',
      'backUrl' => './home',
      'objectsByEmplacement' => $objectsByEmplacement,
      'date_debut' => ((isset($idReservation[0]))?$idReservation[0]['date_debut']:''),
      'date_fin' => ((isset($idReservation[0]))?$idReservation[0]['date_fin']:'')
    ]);
  }

  // Return string of given status
  function getStringStatus($status){
    if($status == 1) return 'Incomplet';
    else if($status == 2) return 'Défectueux';
    else if($status == 3) return 'Moyen';
    else if($status == 4) return 'Bon';
    else if($status == 5) return 'Neuf';
    else return '';
  }
}
