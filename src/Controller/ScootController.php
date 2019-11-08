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
        'arrow' => '' // Hide the back arrow if on main page
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
          'title' => 'Inventaire'
        ]);
    }

    /**
    * @Route("/app/saisi_article", name="saisi_article")
    */
    public function saisi_articles()
    {
      $article = new Article();
      $form = $this -> createForm(ArticleType::class, $article);


      // Handle request if user has completed the form
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $task = $form->getData();


        // Adding user to DB
        // $entityManager = $this->getDoctrine()->getManager();
        // $entityManager->persist($task);
        // $entityManager->flush();

        // Success message

      }


        return $this->render('scoot/saisi_article.html.twig', [
            'form' => $form->createView(),
            'title' => 'Inventaire',

        ]);
    }

    /**
    * @Route("/app/historique", name="historique")
    */
    public function historique()
    {
      return $this->render('scoot/historique.html.twig', [
        'title' => 'Historique',
      ]);
    }

    /**
    * @Route("/app/restituer", name="restituer")
    */
    public function restituer()
    {
      return $this->render('scoot/restituer.html.twig', [
        'title' => 'Restituer',
      ]);
    }

    /**
    * @Route("/app/menu-ajout", name="menuAjout")
    */
    public function ajoutMenu()
    {
      return $this->render('scoot/menu-ajout.html.twig', [
        'title' => 'Menu d\'ajout',
      ]);
    }
}
