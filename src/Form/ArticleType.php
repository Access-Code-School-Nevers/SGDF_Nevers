<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('objet',null,
                  [ 'label' => 'Articles',
                    'attr' => array('placeholder' => '')
                  ])
            ->add('peremption',null,
                  [ 'label' => 'Articles périssable',
                    'attr' => array('placeholder' => '10/11/2020')
                  ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
