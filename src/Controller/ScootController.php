<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Objet;
use App\Form\CreerObjetType;
use App\Entity\Article;
use App\Form\ArticleType;

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
    * @Route("/app/saisi_article", name="saisi_article")
    */
    public function saisi_articles()
    {
      $article = new Article();
      $form = $this -> createForm(ArticleType::class, $article);


        return $this->render('scoot/saisi_article.html.twig', [
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
