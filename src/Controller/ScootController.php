<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Objet;
use App\Form\CreerObjetType;
use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function inventaire(Request $request)
    {
      $creerObjet = new Objet();
      $form = $this -> createForm(CreerObjetType::class, $creerObjet);

      // $form->handleRequest($request);
      // if ($form->isSubmitted() && $form->isValid()) {
      //
      //   //add object to data base
      //   $entityManager = $this->getDoctrine()->getManager();
      //   $entityManager->persist($creerObjet);
      //   $entityManager->flush();
      //
      //   $this->addFlash('success', 'objet créer !');
      //   return $this->redirectToRoute("inventaire");
      // }

        return $this->render('scoot/inventaire.html.twig', [
          'form' => $form->createView(),
          'title' => 'Inventaire test',
          'backUrl' => './menu-ajout',
        ]);

    }


    /**
    * @Route("/app/saisi_article", name="saisi_article")
    */
    public function saisi_articles(Request $request)
    {
      $objects = $this->getDoctrine()->getRepository(Objet::class)->findAll();

      $article = new Article();
      $form = $this -> createForm(ArticleType::class, $article);


      // Handle request if user has submitted the form
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {

         //Adding user to DB
         $entityManager = $this->getDoctrine()->getManager(); //recuperation de l entityManager
         $entityManager->persist($ajoutvaleur); // prepare l objet ajoutvaleur pour le mettre dans bdd
         $entityManager->flush();//envoi l objet dans la bdd

         return new Response('états ajoutés');

         //Success message

    }

      return $this->render('scoot/saisi_article.html.twig', [
          'form' => $form->createView(),
          'title' => 'Inventaire articles',
          'objects' => $objects,
          'backUrl' => './home',
      ]);
  }

    /**
    * @Route("/app/historique", name="historique")
    */
    public function historique()
    {
      return $this->render('scoot/historique.html.twig', [
        'title' => 'Historique',
        'backUrl' => './home',
      ]);
    }

    /**
    * @Route("/app/restituer", name="restituer")
    */
    public function restituer()
    {
      return $this->render('scoot/restituer.html.twig', [
        'title' => 'Restituer',
        'backUrl' => './home',
      ]);
    }

    /**
     * @Route("/app/menu-ajout", name="menu-ajout")
     */
    public function menuAdd()
    {
      return $this->render('scoot/menu-ajout.html.twig', [
        'title' => 'Menu inventaire',
        'backUrl' => './home',
      ]);
    }
}
