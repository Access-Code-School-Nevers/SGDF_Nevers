<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Peremption;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ArticlePerissable extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
