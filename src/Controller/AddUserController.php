<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Form\AddUserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AddUserController extends AbstractController
{
  private $passwordEncoder;

  public function __construct(UserPasswordEncoderInterface $passwordEncoder){
    $this->passwordEncoder = $passwordEncoder;
  }

  /**
   * @Route("/app/ajouter-utilisateur", name="addUser")
   */
  public function addUser(Request $request)
  {
    $newUser = new Utilisateur();
    $form = $this -> createForm(AddUserType::class, $newUser);

    // Handle request if user has completed the form
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $task = $form->getData();

      $task->setPassword($this->passwordEncoder->encodePassword(
        $task, $task->getPassword()
      ));

      // Adding user to DB
      $entityManager = $this->getDoctrine()->getManager();
      $entityManager->persist($task);
      $entityManager->flush();

      // Success message
      $this->addFlash('success', 'Utilisateur créé !');
      return $this->redirectToRoute("addUser");
    }

    // Render the form
    return $this->render('scoot/addUser.html.twig', [
        'form' => $form->createView(),
        'title' => 'Ajouter un Utilisateur'
    ]);
  }
}
