<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticlePerissable extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('objet', TextType::class, [
          'attr' => array('list' => 'objects')
        ])
        ->add('peremption', DateType::class, array(
          'widget' => 'single_text',
        ))
<<<<<<< HEAD
=======
        ->add('scan', ButtonType::class, [
          'attr' => array('class' => 'button_scan_restituer')
        ])
>>>>>>> 01d1db2ffc10c78d0458a7a9c4c1366ed27ea55c
        ->add('ajouter', SubmitType::class, [
          'attr' => ['class' => 'w-100 btn-primary main-blue-color second-blue-color']
        ])

        ->getForm()
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
