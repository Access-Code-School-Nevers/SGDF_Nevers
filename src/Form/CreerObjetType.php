<?php

namespace App\Form;

use App\Entity\Objet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreerObjetType extends AbstractType
{
  // Function that automatically build the form with data of Objet entity
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
        ->add('titre',TextType::class, ['required' => false])
        ->add('description',TextareaType::class, ['required' => false])
        ->add('pcb',IntegerType::class, ['label' => 'par combien'])
        ->add('perissable',ChoiceType::class, ['choices' =>[
          'périssable' => 1,
          'non périssable' => 0]]
        )
        ->add('photo')
        ->add('enregistrer', SubmitType::class,[
          'attr' => ['class' => 'btn btn-primary main-blue-color second-blue-color']
        ])
        ->getForm();

    ;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
        'data_class' => Objet::class,
    ]);
  }
}
