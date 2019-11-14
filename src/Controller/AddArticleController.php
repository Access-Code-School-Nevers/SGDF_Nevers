<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use App\Entity\Objet;
use App\Entity\Etat;
use App\Entity\Emplacement;
use App\Form\ArticleNonPerissable;

class AddArticleController extends AbstractController
{
  /**
  * @Route("/app/saisi_article", name="saisi_article")
  */
  public function saisi_articles(Request $request)
  {
    $objects = $this->getDoctrine()->getRepository(Objet::class)->findAll();

    $article = new Article();
    $form = $this -> createForm(ArticleNonPerissable::class, $article);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      // Get all variables
      $neuf = intval($request->request->get('neuf'));
      $bon = intval($request->request->get('bon'));
      $moyen = intval($request->request->get('moyen'));
      $defectueux = intval($request->request->get('defectueux'));
      $incomplet = intval($request->request->get('incomplet'));
      $objet = $request->request->get('objet');
      $cab = intval($request->request->get('cab'));
      $articles = [];

      $nbArticlesTotal = $neuf + $bon + $moyen + $defectueux + $incomplet;

      // Check that user filled all input
      if($nbArticlesTotal > 0 && $objet != "" && $cab != ""){
        $etatArticles = [];

        // Adding all status to create articles later
        $etatArticles = $this->addToEtat($neuf, 5, $etatArticles);
        $etatArticles = $this->addToEtat($bon, 4, $etatArticles);
        $etatArticles = $this->addToEtat($moyen, 3, $etatArticles);
        $etatArticles = $this->addToEtat($defectueux, 2, $etatArticles);
        $etatArticles = $this->addToEtat($incomplet, 1, $etatArticles);

        // Getting objet by his name
        $recupere_objet_props = $this->getDoctrine()->getRepository(Objet::class);
        $product = $recupere_objet_props->findBy(['titre'=>$objet]);

        // Getting emplacement by his id
        $recupere_emplacement_props = $this->getDoctrine()->getRepository(Emplacement::class);
        $cab = $recupere_emplacement_props->findBy(['id'=>$cab]);

        // Creating articles and status
        for($i=0 ; $i<$nbArticlesTotal ; $i++){
          $etats[$i] = new Etat();
          $etats[$i]->setEtat($etatArticles[$i]);

          $articles[$i] = new Article();
          $articles[$i]->setObjet($product[0]);
          $articles[$i]->setEmplacement($cab[0]);
          $articles[$i]->setEtat($etats[$i]);

          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($articles[$i]);

          $displayArticles[$i]['etat'] = $this->getStringStatus($etatArticles[$i]);
        }

        // Insert into DB
        $entityManager->flush();

        for($i=0 ; $i<$nbArticlesTotal ; $i++){
          $this->addFlash('newBarcode', $this->getStringStatus($etatArticles[$i]).','.$articles[$i]->getId());
        }

        // Success message
        $this->addFlash('displayModal', "1");
        $this->addFlash('success', 'Articles créés avec succès !');
        return $this->redirectToRoute("saisi_article");
      }
      else
        $this->addFlash('danger', 'Au moins un champ n\'est pas renseigné.');
    }

    return $this->render('scoot/saisi_article.html.twig', [
        'form' => $form->createView(),
        'title' => 'Inventaire articles',
        'objects' => $objects,
        'backUrl' => './home',
    ]);
  }

  // Add status of article into a table to add them easily later to db
  public function addToEtat($nb,$etat,$table){
    for($i=0 ; $i<$nb ; $i++){
      array_push($table,$etat);
    }

    return $table;
  }

  // Return string of given status
  function getStringStatus($status){
    if($status == 1) return 'Incomplet';
    else if($status == 2) return 'Défectueux';
    else if($status == 3) return 'Moyen';
    else if($status == 4) return 'Bon';
    else if($status == 5) return 'Neuf';
    else return '';
  }
}
