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
      ->add('nom')
      ->add('password', PasswordType::class)
      ->add('role', ChoiceType::class, [
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
