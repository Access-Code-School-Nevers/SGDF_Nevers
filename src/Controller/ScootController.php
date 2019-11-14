<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;
use App\Entity\Objet;
use App\Form\CreerObjetType;
use App\Entity\Article;
use App\Form\ArticlePerissable;
use App\Form\ArticleNonPerissable;
use App\Form\EmplacementType;
use App\Entity\Emplacement;
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
      $reservations = $this->getDoctrine()->getRepository(Reservation::class)->getNumberOfReservation($this->getUser()->getId());

      return $this->render('scoot/home.html.twig', [
        'title' => 'Accueil',
        'arrow' => '', // Hide the back arrow if on main page
        'reservations' => $reservations
      ]);
    }

    /**
     * @Route("/app/inventaire", name="inventaire")
     */
    public function inventaire(Request $request)
    {
      $creerObjet = new Objet();
      $form = $this -> createForm(CreerObjetType::class, $creerObjet);

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        if(!empty($_POST['titre']) && !empty($_POST['description']) && !empty($_POST['pcb']) && !empty($_POST['perissable']))
        {
        }
        else
        {
          $error = "tous les champs du formulaire doivent être remplis excepté celui des photos";
        }
        //add object to data base
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($creerObjet);
        $entityManager->flush();

        $this->addFlash('success', 'objet créer !');
        return $this->redirectToRoute("inventaire");
      }

        return $this->render('scoot/inventaire.html.twig', [
          'form' => $form->createView(),
          'title' => 'Inventaire test',
          'backUrl' => './menu-ajout',
        ]);

    }



    /**
    * @Route("/app/saisi_article_perissable", name="saisi_article_perissable")
    */
    public function saisi_articles_perissables(Request $request)
    {
      $objects = $this->getDoctrine()->getRepository(Objet::class)->findAll();

      $article = new Article();
      $form = $this -> createForm(ArticlePerissable::class, $article);

      // Handle request if user has submitted the form
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
         //get the database ID of the article object
         $id_article = $request->request->get('id');
         //  the name of the object 'objet' is the name of the input in the form
         $objet = $request->request->get('objet');
         // We take the proprerties and functions of "Objet" Entity that we put in var $objets
         $recupere_Objet_props = $this->getDoctrine()->getRepository(Objet::class);
         //I get the object dial in the input "objet" box by the user
         $product=$recupere_Objet_props->findBy(['titre'=>$objet]);
         //Adding user to DB
         // $entityManager = $this->getDoctrine()->getManager(); //recuperation de l entityManager
         // $entityManager->persist($ajoutvaleur); // prepare l objet ajoutvaleur pour le mettre dans bdd
         // $entityManager->flush();//envoi l objet dans la bdd



         //Success message

    }

      return $this->render('scoot/saisi_article_perissable.html.twig', [
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
