<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;
use App\Form\ReservezForm;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Objet;
use App\Entity\ReservationHasArticles;

class ReservezController extends AbstractController
{
  /**
  * @Route("/app/reservez", name="reservez")
  */
    public function index(Request $request)
    {
      $newReservation = new Reservation();
      $form = $this -> createForm(ReservezForm::class, $newReservation);

      // Handle request if user has completed the form
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $reservation = $form->getData();
        $objects = $request->request->get('listObjects');
        $quantities = $request->request->get('quantityObjects');

        $dateFormat = $request->request->get('reservez_form')['dateDebut'];

        // Check that we have objects selected
        if(count($objects) > 0 && count($quantities) > 0 && count($objects) == count($quantities)){
          $listItems = [];
          $listObjectsInDb = $this->getDoctrine()->getRepository(Objet::class)->getAvailablesObjets($dateFormat);

          for($i=0, $v=count($objects) ; $i<$v ; $i++){
            for($y=0, $z=count($listObjectsInDb) ; $y<$z ; $y++){
              if($objects[$i] == $listObjectsInDb[$y]['titre'] && $quantities[$i] <= $listObjectsInDb[$y]['quantite']){
                $listItems[$i] = explode(',',$listObjectsInDb[$y]['id_article']);
                break;
              }
            }
          }

          // All articles found and quantities are available
          if(count($listItems) == count($objects)){
            $reservation->setUtilisateur($this->getUser()->getId())
                        ->setStatut(1);
dump($reservation);
            // Create reservation
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($reservation);
            // $entityManager->flush();

            // Add articles to reservation
            $nbArticlesTotal = 0;
            for($i=0, $v=count($objects) ; $i<$v ; $i++){
              for($y=0, $z=$quantities[$i] ; $y<$z ; $y++){
                $reservationHasArticles[$nbArticlesTotal] = new ReservationHasArticles();
                // $reservationHasArticles[$nbArticlesTotal]->setReservation($reservation->getId());
                $reservationHasArticles[$nbArticlesTotal]->setReservation(1);
                $reservationHasArticles[$nbArticlesTotal]->setArticle($listItems[$i][$y]);
                $nbArticlesTotal++;
              }
            }
dump($reservationHasArticles);


            // If perishable, modify values in Peremption table, archive = 1
          }
        }


        // 1. Verify that articles exists and have correct quantities
        // 2. Create reservation and add articles to reservation
        // 2b. Modify perishable articles into peremption (archive = 1)

        // Adding user to DB
        // $entityManager = $this->getDoctrine()->getManager();
        // $entityManager->persist($task);
        // $entityManager->flush();

        // Success message
        // $this->addFlash('success', 'Utilisateur créé !');
        // return $this->redirectToRoute("addUser");
      }

      return $this->render('scoot/reservez.html.twig', [
          'form' => $form->createView(),
          'title' => 'Je réserve',
          'backUrl' => './home',
      ]);
    }
}
