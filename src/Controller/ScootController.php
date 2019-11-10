<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
          'title' => 'Inventaire test'
        ]);

    }


    /**
    * @Route("/app/saisi_article", name="saisi_article")
    */

    
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



          // if($_POST) {
          //   require 'validation.php';
          //
          //   $ajoutvaleur = array(
          //     'neuf' => '[01234]|required || null|required',
          //     'bon' => '[01234]|required || null|required',
          //     'moyen' => '[01234]|required || null|required',
          //     'defectueux' => '[01234]|required || null|required',
          //     'incomplet' => '[01234]|required || null|required',
          //   );
          //   $validation = new Validation();
          //
          //   if($validation->validate($_POST, $ajoutvaleur) == true) {
          //     var_dump($_POST);
          //   }
          //   else {
          //     echo '<ul>';
          //     foreach ($validation->errors as $error) {
          //       echo '<li>' . $error . '</li>';
          //     }
          //     echo '</ul>';
          //   }
          // }



         //Adding user to DB
         $entityManager = $this->getDoctrine()->getManager(); //recuperation de l entityManager
         $entityManager->persist($ajoutvaleur); // prepare l objet ajoutvaleur pour le mettre dans bdd
         $entityManager->flush();//envoi l objet dans la bdd

         return new Response('états ajoutés');

         //Success message

    }
            return $this->render('scoot/saisi_article.html.twig', [
                'form' => $form->createView(),
                'title' => 'Inventaire articles'

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
}
