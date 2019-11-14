<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
    * @Route("/app/saisi_article", name="saisi_article")
    */
    public function saisi_articles(Request $request)
    {
// field tab article creation of a new article

// We find all the objetcs that have the properties and functions of "Objet" Entity that we put in a tab
      $objects = $this->getDoctrine()->getRepository(Objet::class)->findAll();


      $article = new Article();
      $form = $this -> createForm(ArticleNonPerissable::class, $article);


      // Handle request if user has submitted the form
       $form->handleRequest($request);
       if ($form->isSubmitted() && $form->isValid()) {

          //  the name of the object 'objet' is the name of the input in the form
          $objet = $request->request->get('objet');
          // We take the proprerties and functions of "Objet" Entity that we put in var $objets
          $recupere_Objet_props = $this->getDoctrine()->getRepository(Objet::class);
          //I get the object dial in the input "objet" box by the user
          $product=$recupere_Objet_props->findBy(['titre'=>$objet]);



          ////// id Emplacement///////

          //We take the proprerties and functions of Entity "Emplacement" et les fonctions de son Repository
    // $recupere_Emplacement_props = $this->getDoctrine()->getRepository(Emplacement::class);

         // get the number entered in the code a barre field
         //cab is the name of the input of the cab
         $cab = $request->request->get('cab');
         // We take the Object "Emplacement" with his proprerties and functions from Entity tab that we put in a var
         $recupere_Emplacement_props = $this->getDoctrine()->getRepository(Emplacement::class);


          //on recupere le cab de input ou il y a le code a bar
         $cab_recuperer=$recupere_Emplacement_props->findBy(['id'=>$cab]);

        //  if(isset($product[0]&&$cab_recuperer[0])){
          // set of Entity "Objet"
          $article->setObjet($product[0]);
          // set of Entity "Emplacement"
         $article->setEmplacement($cab_recuperer[0]);


/////////////// Fill "etat" table in dbb (for the moment "article table do not exist") ///////////
         $newEtat = new Etat();


         $article_neuf = ($request->request->get('neuf'));
         $article_bon = ($request->request->get('bon'));
         $article_moyen = ($request->request->get('moyen'));
         $article_defectueux = ($request->request->get('defectueux'));
         $article_incomplet = ($request->request->get('incomplet'));

         $nbr_articles = $article_neuf + $article_bon + $article_moyen + $article_defectueux + $article_incomplet;
         $tab_id = array();
         $compteur = 0;


         // we fill or tab "$tab_art_crees" with all the articles dial in the form saisi_article

         if ('$article_neuf' not NULL)
         for (i=1;i<$article_neuf+1;i++) {
           $tab_id[]=i
           $newEtat->setEtat(tab_id[i])
         }

         for (art in $tab_art_crees[]) {
           $etat_etat = $this->getDoctrine()->getRepository(Article::class)->findBy(['id' => art]);
           $etat->getEtat();
           $tab_etat[]=etat;

         }

        for (i=0;i<$nbr_articles,i++) {
          // set the article ID in "etat" database
          $newEtat->setArticle($etat_id[i]);
          $newEtat->setEtat($etat_etat[i]);
        }

        $entityManager = $this->getDoctrine()->getManager(); //use the entityManager
        $entityManager->persist($task); //   objet "article" ready to be flush in dbb
        $entityManager->flush();

         //Success message

//Success message
// $this->addFlash('success', 'Article crée avec succès!');
// return $this->redirectToRoute("saisi_article");


      return $this->render('scoot/saisi_article.html.twig', [
          'form' => $form->createView(),
          'title' => 'Inventaire articles',
          'objects' => $objects,
          'backUrl' => './home',
      ]);
  }
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
