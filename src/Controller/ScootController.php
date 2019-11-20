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

        $formData = $form->getData();
        $titre = $formData->getTitre();
        // var_dump($request);
        // dump($titre);
        $recup_titre = $this->getDoctrine()->getRepository(Objet::class);
        $product = $recup_titre->findBy(['titre'=>$titre]);

        if (count($product) == 0) {
          //add object to data base
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($creerObjet);
          $entityManager->flush();


        } else {
            $this->addFlash('danger', 'Objet déjà existant');
        }

        $this->addFlash('success', 'Objet créé !');
        return $this->redirectToRoute("inventaire");
      }

      return $this->render('scoot/inventaire.html.twig', [
        'form' => $form->createView(),
        'title' => 'Inventaire test',
        'backUrl' => './menu-ajout',
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
