<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;
use App\Form\ReservezForm;
use App\Entity\Objet;

class ReservezController extends AbstractController
{
  /**
  * @Route("/app/reservez", name="reservez")
  */
    public function index()
    {
      $newReservation = new Reservation();
      $form = $this -> createForm(ReservezForm::class, $newReservation);

      return $this->render('scoot/reservez.html.twig', [
          'form' => $form->createView(),
          'title' => 'Je réserve',
          'backUrl' => './home',
      ]);
    }
}
