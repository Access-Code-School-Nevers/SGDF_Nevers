<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/reservez", name="reservez")
     */
    public function reservez()
    {
        return $this->render('scoot/reservez.html.twig', [

        ]);
    }

}
