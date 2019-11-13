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

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid())
      {

        $creerObjet = $form->getData();

        if(!empty($_POST['titre']) && !empty($_POST['description']) && !empty($_POST['pcb']) && !empty($_POST['perissable']))
        {

        }
        else
        {
          echo "tous les champs du formulaire doivent être remplis excepté celui des photos";
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
    * @Route("/app/saisi_article", name="saisi_article")
    */

/*
// Méthode(EDDY)
    public function index()
    {
        // find qui permet de récupérer les données dans la bdd avec ici le critère de filtre par id
        $objet = $this->getDoctrine()->getRepository(Objet::class)->find([id]);

        // j'envoie les données à la vue
        return $this->render('scoot/saisi_article.html.twig', [
            'objet' => '$objet',
        ]);
    }
// fin methode Eddy
*/
//Autre methode
/**
    * @Route("/handle_search/{_query?}", name="handle_search", methods={"POST", "GET"})
    */
   public function handleSearchRequest(Request $request, $_query)
   {
       $em = $this->getDoctrine()->getManager();
       if ($_query)
       {
           $data = $em->getRepository(Objet::class)->findByName($_query);
       } else {
           $data = $em->getRepository(Objet::class)->findAll();
       }

       // setting up the serializer
       $normalizers = [
           new ObjectNormalizer()
       ];
       $encoders =  [
           new JsonEncoder()
       ];
       $serializer = new Serializer($normalizers, $encoders);
       $data = $serializer->serialize($data, 'json');
       return new JsonResponse($data, 200, [], true);
   }

   /**
    * @Route("/objet/{id?}", name="objet_page", methods={"GET"})
    */
    public function objetSingle(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $objet = null;

        if ($id) {
            $objet = $em->getRepository(Objet::class)->findOneBy(['id' => $id]);
        }
        return $this->render('scoot/saisi_article.html.twig', [
            'objet' => $objet,
            'backUrl' => './home',
        ]);
    }

//fin autre methode

    /**
    * @Route("/app/saisi_article", name="saisi_article")
    */
    public function saisi_articles(Request $request)
    {
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
}
