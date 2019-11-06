<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Objet;
use App\Form\CreerObjetType;


class ScootController extends AbstractController
{
    /**
     * @Route("/app/home", name="home")
     */
    public function home()
    {
        return $this->render('scoot/home.html.twig', [
          'title' => 'Accueil',
          'arrow' => ''
        ]);
    }

    /**
     * @Route("/app/inventaire", name="inventaire")
     */
    public function inventaire()
    {
      $creerObjet = new Objet();
      $form = $this -> createForm(CreerObjetType::class, $creerObjet);


        return $this->render('scoot/inventaire.html.twig', [
            'form' => $form->createView(),
            'title' => 'Inventaire',

        ]);
    }

    /**
    * @Route("/app/reservez", name="reservez")
    */
    public function reservez()
    {
      return $this->render('scoot/reservez.html.twig', [
        'title' => 'Je réserve',
      ]);
    }

}
