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
        return $this->render('scoot/home.html.twig', [

        ]);
    }


    /**
     * @Route("/app/inventaire", name="reservez")
     */
    public function inventaire()
    { $creerObjet = new CreerObjet();
        $form = $this -> createForm(CreerObjetType::class, $creerObjet);

        return $this->render('scoot/inventaire.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
