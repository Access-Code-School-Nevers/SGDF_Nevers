<?php
namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class ReservezForm extends AbstractType
{
  // Function that automatically build the form with data of User entity
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('dateDebut', DateType::class, array(
          'widget' => 'single_text',
    ))
      ->add('dateFin', DateType::class, array(
            'widget' => 'single_text',
      ))
      ->add('Valider', SubmitType::class, [
          'attr' => ['class' => 'w-100 btn-primary main-blue-color second-blue-color'],
        ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
        'data_class' => Reservation::class,
    ]);
  }
}
