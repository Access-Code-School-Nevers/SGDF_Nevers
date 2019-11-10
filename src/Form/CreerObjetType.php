<?php

namespace App\Form;

use App\Entity\Objet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreerObjetType extends AbstractType
{
  // Function that automatically build the form with data of Objet entity
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
        ->add('titre')
        ->add('description')
        ->add('pcb')
        ->add('photo')
    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
        'data_class' => Objet::class,
    ]);
  }
}
