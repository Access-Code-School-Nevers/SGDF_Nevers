<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\CreerObjet;
use App\Form\CreerObjetType;

class ScootController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home()
    {
        return $this->render('scoot/home.html.twig', [

        ]);
    }


    /**
       * @Route("/reservez", name="reservez")
       */
      public function reservez()
      {
          return $this->render('scoot/reservez.html.twig', [
          ]);
      }



    /**
     * @Route("/inventaire", name="inventaire")
     */
    public function inventaire()
    { $creerObjet = new CreerObjet();
        $form = $this -> createForm(CreerObjetType::class, $creerObjet);

        return $this->render('scoot/inventaire.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
