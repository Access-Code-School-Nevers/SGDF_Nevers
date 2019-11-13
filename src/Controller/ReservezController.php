<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;
use App\Entity\Peremption;
use App\Entity\ReservationHasArticles;
use App\Form\ReservezForm;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Objet;

class ReservezController extends AbstractController
{
  /**
  * @Route("/app/reservez", name="reservez")
  */
    public function reservez(Request $request)
    {
      $newReservation = new Reservation();
      $form = $this -> createForm(ReservezForm::class, $newReservation);

      // Handle request if user has completed the form
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $reservation = $form->getData();
        $objects = $request->request->get('listObjects');
        $nbObjects = ((is_array($objects))?count($objects):0);
        $quantities = $request->request->get('quantityObjects');
        $nbQuantities = ((is_array($quantities))?count($quantities):0);

        $dateFormat = $request->request->get('reservez_form')['dateDebut'];

        // Check that we have objects selected
        if($nbObjects > 0 && $nbQuantities > 0 && $nbObjects == $nbQuantities){
          $listItems = [];
          $listArticlesPerishable = [];
          $reservationHasArticles = [];
          $listObjectsInDb = $this->getDoctrine()->getRepository(Objet::class)->getAvailablesObjets($dateFormat);

          // Verify that each articles selected are available
          for($i=0, $v=$nbObjects ; $i<$v ; $i++){
            for($y=0, $z=count($listObjectsInDb) ; $y<$z ; $y++){
              if($objects[$i] == $listObjectsInDb[$y]['titre'] && $quantities[$i] <= $listObjectsInDb[$y]['quantite']){
                $listItems[$i] = explode(',',$listObjectsInDb[$y]['id_article']);

                // Get articles for the reservation
                for($a=0, $b=$quantities[$i] ; $a<$b ; $a++){
                  array_push($reservationHasArticles,$listItems[$i][$a]);

                  // Get the article id if perishable, to modify archive value after
                  if($listObjectsInDb[$y]['perissable'] == 1)
                    array_push($listArticlesPerishable,$listItems[$i][$a]);
                }

                break;
              }
            }
          }

          // All articles found and quantities are available
          if(count($listItems) == $nbObjects && $nbObjects > 0 && count($reservationHasArticles) > 0){
            $reservation->setUtilisateur($this->getUser())
                        ->setStatut(1);

            // Create reservation
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();

            // Add articles to reservation
            $this->getDoctrine()->getRepository(ReservationHasArticles::class)->addArticlesToReservation($reservation->getId(),$reservationHasArticles);

            // If perishable, modify values in Peremption table, archive = 1
            if(count($listArticlesPerishable) > 0){
              $this->getDoctrine()->getRepository(Peremption::class)->addArticlesToArchive($listArticlesPerishable);
            }

            // Success message
            $this->addFlash('success', 'Réservation effectuée !');
            return $this->redirectToRoute("reservez");
          }
          else{
            $this->addFlash('danger', 'Certains articles ne sont plus disponibles.');
            return $this->redirectToRoute("reservez");
          }
        }
        else{
          $this->addFlash('danger', "Une erreur s'est produite. Nous n'avons pas pu trouvé vos articles.");
          return $this->redirectToRoute("reservez");
        }
      }

      return $this->render('scoot/reservez.html.twig', [
          'form' => $form->createView(),
          'title' => 'Je réserve',
          'backUrl' => './home',
      ]);
    }
}
