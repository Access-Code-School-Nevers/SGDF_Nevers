<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Objet;
use App\Form\CreerObjetType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddObjectController extends AbstractController
{
    /**
     * @Route("/add/object", name="inventaire")
     */
    public function addObjet(Request $request)
    {
      $objet = new Objet();
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $objetInfo = $form->getData();

        //add object to data base
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($objetInfo);
        $entityManager->flush();

        $this->addFlash('success', 'objet créer !');
        return $this->redirectToRoute("inventaire");
      }
        return $this->render('scoot/inventaire.html.twig', [
            'controller_name' => 'AddObjectController',
        ]);
    }
}
