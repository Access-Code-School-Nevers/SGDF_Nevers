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

        ->add('peremption', DateType::class, array(
          'widget' => 'single_text',
        ))
        // ->add('archive', NumberType::class, ['label' => 'code barre'])
        
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
