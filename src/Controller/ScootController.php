<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CreerObjet;
use App\Form\CreerObjetType;

class ScootController extends AbstractController
{
    /**
     * @Route("/app/home", name="home")
     */
    public function home()
    {
      $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('scoot/home.html.twig', [

        ]);
    }


    /**
     * @Route("/app/inventaire", name="inventaire")
     */
    public function inventaire()
    { $creerObjet = new CreerObjet();
        $form = $this -> createForm(CreerObjetType::class, $creerObjet);

        return $this->render('scoot/inventaire.html.twig', [
            'form' => $form->createView(),
        ]);
    }
      /**
    * @Route("/app/reservez", name="reservez")
    */
    public function reservez()
    {
      return $this->render('scoot/reservez.html.twig', [
      ]);
    }
}
