<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use App\Entity\Objet;
use App\Entity\Emplacement;
use App\Form\ArticlePerissable;

class AddArticlePerishableController extends AbstractController
{
////////////add  perishable articles//////////////



  // /**
  // * @Route("/app/saisi_article_perissable", name="saisi_article_perissable")
  // */
  public function saisi_articles_perissables(Request $request)
  {
    $objects = $this->getDoctrine()->getRepository(Objet::class)->findAll();

    $article = new Article();
    $form = $this -> createForm(ArticlePerissable::class, $article);


    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $task = $form->getData();

      //get the total numeber of object  (eg : 5 packs of water  we get 5)
      $nbArticles = intval($request->request->get('quantite'));
      // Getting objet by his name
      // Check that user filled all input
      if($nbArticlesTotal > 0 && $objet != "" && $cab != ""){

      $etatArticles = [];
      $recupere_objet_props = $this->getDoctrine()->getRepository(Objet::class);
      $product = $recupere_objet_props->findBy(['titre'=>$objet]);

      // Getting emplacement by his id
      $recupere_emplacement_props = $this->getDoctrine()->getRepository(Emplacement::class);
      $cab = $recupere_emplacement_props->findBy(['id'=>$cab]);


      if(count($product) > 0 && count($cab) > 0){
      // Creating articles and status
      for($i=0 ; $i<$nbArticles ; $i++){

        $articles[$i] = new Article();
        $articles[$i]->setObjet($product[0]);
        $articles[$i]->setEmplacement($cab[0]);
        // $articles[$i]->setDatePeremption($peremption[$i]);

// Insert into DB
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($articles[$i]);
        $entityManager->flush();

      }



      // Success message
      $this->addFlash('displayModal', "1");
      $this->addFlash('success', 'Articles créés avec succès !');
      return $this->redirectToRoute("saisi_article_perissable");



    }
    else
      $this->addFlash('danger', 'Au moins un champ n\'est pas renseigné.');
    }
  }


    return $this->render('scoot/saisi_article_perissable.html.twig', [
      'form' => $form->createView(),
      'title' => 'Inventaire articles',
      'objects' => $objects,
      'backUrl' => './home',
    ]);
    }
  }
