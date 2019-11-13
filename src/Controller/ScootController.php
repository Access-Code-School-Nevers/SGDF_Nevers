<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Objet;
use App\Form\CreerObjetType;
use App\Entity\Article;
use App\Form\ArticleNonPerissable;
use App\Entity\Emplacement;
use App\Form\ArticlePerissable;
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

         //Adding user to DB
         $entityManager = $this->getDoctrine()->getManager(); //recuperation de l entityManager
         $entityManager->persist($ajoutvaleur); // prepare l objet ajoutvaleur pour le mettre dans bdd
         $entityManager->flush();//envoi l objet dans la bdd

         return new Response('états ajoutés');

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
    * @Route("/app/saisi_article", name="saisi_article")
    */
    public function saisi_articles(Request $request)
    { // We take the proprerties and functions of "Objet" Entity that we put in var $objets
      $objects = $this->getDoctrine()->getRepository(Objet::class)->findAll();
      // creation of a new article
      $article = new Article();
      $form = $this -> createForm(ArticleNonPerissable::class, $article);
      $task = $form->getData();

      // Handle request if user has submitted the form
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {
//get the ID of the article
$id_article = $request->request->get('id');
//get the quantity of the field "neuf"
$neuf = $request->request->get('neuf');
$bon = $request->request->get('bon');
$moyen = $request->request->get('moyen');
$defectueux = $request->request->get('defectueux');
$incomplet = $request->request->get('incomplet');
$objet = $request->request->get('objet');

// get the code a barre of the user
$cab = $request->request->get('cab');

// We take the proprerties and functions of "Objet" Entity that we put in var $objets
$recupere_Objet_props = $this->getDoctrine()->getRepository(Objet::class);
//I get the object dial in the input "objet" box by the user
$product=$recupere_Objet_props->findBy(['titre'=>$objet]);
// recuperation de l id de l objet
// $id_objet = $product.id;


////// id Emplacement///////

//We take the proprerties and functions of Entity "Emplacement" et les fonctions de son Repository
$recupere_Emplacement_props = $this->getDoctrine()->getRepository(Emplacement::class);

//on recupere le cab de input ou il y a le code a bar
$cab=$recupere_Emplacement_props->findBy(['id'=>$cab]);

// set of Entity "Objet"
$article->setObjet($product[0]);
// set of Entity "Emplacement"
$article->setEmplacement($cab[0]);

$entityManager = $this->getDoctrine()->getManager(); //use the entityManager
$entityManager->persist($article); //   objet "article" ready to be flush in dbb
$entityManager->flush();





// if($neuf>0)
// $etat='5'
// for(i=0;i<$neuf;i++) {
  // $entityManager = $this->getDoctrine()->getManager(); //recuperation de l entityManager
  // $entityManager->persist($cab); // prepare l objet ajoutvaleur pour le mettre dans bdd
  // $entityManager->flush();
//}



// Success message
$this->addFlash('success', 'Article crée avec succès!');
return $this->redirectToRoute("saisi_article");
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

    /**
    * @Route("/app/retrait", name="retrait")
    */
    public function retrait()
    {
      return $this->render('scoot/retrait.html.twig', [
        'title' => 'retrait',
        'backUrl' => './home',
      ]);
    }
}
