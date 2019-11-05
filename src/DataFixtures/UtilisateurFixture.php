<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurFixture extends Fixture
{
  private $passwordEncoder;

  public function __construct(UserPasswordEncoderInterface $passwordEncoder){
    $this->passwordEncoder = $passwordEncoder;
  }

  public function load(ObjectManager $manager)
  {
    $user = new Utilisateur();
    $user->setNom('admin');
    $user->setPassword($this->passwordEncoder->encodePassword(
      $user, '123'
    ));
    $user->setRole(1);
    $manager->persist($user);

    $user = new Utilisateur();
    $user->setNom('responsable');
    $user->setPassword($this->passwordEncoder->encodePassword(
      $user, '123'
    ));
    $user->setRole(2);
    $manager->persist($user);

    $user = new Utilisateur();
    $user->setNom('chef');
    $user->setPassword($this->passwordEncoder->encodePassword(
      $user, '123'
    ));
    $user->setRole(3);
    $manager->persist($user);

    $manager->flush();
  }
}
