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

    // Get all the articles reserved
    $articles = $this->getDoctrine()->getRepository(Reservation::class)->getReservationArticles($idReservation[0]['id'],1);

/*
    tableau d'objets :
      - emplacement
      - objet_id
      - articles_id []
      - titre
*/

    // Parse articles to regroup them in visual
    $objectsByEmplacement = [];
    foreach($articles as $article){
      if(!isset($objectsByEmplacement[$article['emplacement_id']]))
        $objectsByEmplacement[$article['emplacement_id']] = [];

      if(!isset($objectsByEmplacement[$article['emplacement_id']][$article['objet_id']])){
        $objectsByEmplacement[$article['emplacement_id']][$article['objet_id']]['titre'] = $article['titre'];
        $objectsByEmplacement[$article['emplacement_id']][$article['objet_id']]['listArticles'] = [];
      }

      array_push($objectsByEmplacement[$article['emplacement_id']][$article['objet_id']]['listArticles'],$article['article_id']);
    }
    dump($objectsByEmplacement);

    // Handle request if user has completed the form
    // if($request->request->get('codebar1')){
    //   $hasFilledAll = 1;
    //
    //   // Check if all barcode inserted are correct with the values asked
    //   for($i=0, $v=count($articles) ; $i<$v ; $i++){
    //     if($request->request->get('codebar'.($i+1)) && is_numeric(intval($request->request->get('codebar'.($i+1))))){
    //       if(intval($request->request->get('codebar'.($i+1))) != intval($articles[$i]['emplacement_id'])){
    //         $hasFilledAll = 0;
    //         break;
    //       }
    //     }
    //     else{
    //       $hasFilledAll = 0;
    //       break;
    //     }
    //   }
    //
    //   // Update status of reservation
    //   if($hasFilledAll == 1){
    //     $articles = $this->getDoctrine()->getRepository(Reservation::class)->updateReservationStatus($idReservation[0]['id'],2);
    //
    //     // Success message
    //     $this->addFlash('success', 'Retrait enregistré !');
    //     return $this->redirectToRoute("home");
    //   }
    // }


    return $this->render('scoot/retrait.html.twig', [
      'title' => 'retrait',
      'backUrl' => './home',
      'objectsByEmplacement' => $objectsByEmplacement
    ]);
  }
}
