<?php

namespace App\Controller;

use App\Entity\Emplacement;
use App\Entity\Site;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EmplacementType;
use Symfony\Component\HttpFoundation\Request;

class AddLocationController extends AbstractController
{
  /**
   * @Route("/app/ajout-emplacement", name="ajout-emplacement")
   */
  public function addLocation(Request $request)
  {
    // Get all sites to create a datalist
    $sites = $this->getDoctrine()->getRepository(Site::class)->findAll();

    $newEmplacement = new Emplacement();
    $form = $this -> createForm(EmplacementType::class, $newEmplacement);

    // Handle request if user has completed the form
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $task = $form->getData();
      $idSite = intval($request->request->get('siteId'));

      if(is_numeric($idSite)){
        // getting site id if exists
        $sites = $this->getDoctrine()->getRepository(Site::class)->findBy(['id' => $idSite]);

        if(isset($sites[0])){
          $newEmplacement->setSite($sites[0]);

          // Adding user to DB
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($newEmplacement);
          $entityManager->flush();

          // Success message
          $this->addFlash('newBarcode', $newEmplacement->getId());
          $this->addFlash('success', 'Emplacement crée !');
          return $this->redirectToRoute("ajout-emplacement");
        }
      }
    }

    return $this->render('scoot/addLocation.html.twig', [
      'form' => $form->createView(),
      'title' => 'Ajouter un emplacement',
      'backUrl' => './menu-ajout',
      'sites' => $sites
    ]);
  }
}
