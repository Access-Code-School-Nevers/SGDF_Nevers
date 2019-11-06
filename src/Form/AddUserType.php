<?php
namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddUserType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('nom', null,
          [ 'label' => false,
            'attr' => array('placeholder' => 'Nom de l\'utilisateur')
          ])
      ->add('password', PasswordType::class,
          [ 'label' => false,
            'attr' => array('placeholder' => 'Mot de passe')
          ])
      ->add('role', ChoiceType::class, [
          'label' => false,
          'choices' => [
            'Administrateur' => 1,
            'Responsable matériel' => 2,
            'Chef' => 3
          ],
        ])
      ->add('save', SubmitType::class, [
          'attr' => ['class' => 'w-100 btn-primary main-blue-color'],
        ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
        'data_class' => Utilisateur::class,
    ]);
  }
}
