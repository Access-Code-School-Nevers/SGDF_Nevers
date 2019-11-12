<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Objet;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
  /**
   * @Route("/api/objets-disponibles", name="apiGetAvailablesObjects")
   */
  public function getAvailablesObjets(Request $request)
  {
    $date = $request->query->get('date');
    $objects = $this->getDoctrine()->getRepository(Objet::class)->getAvailablesObjets($date);

    return $this->json($objects);
  }
}
