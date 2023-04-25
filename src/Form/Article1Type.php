<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Article1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title')
        ->add('imageForm',  FileType::class, [
            'mapped' => false, 'required' => false
        ])
        ->add('Introduction')
        ->add('TitreSecondaire')
        ->add('content')
        ->add('TitreConclusion')
        ->add('Conclusion')
        ->add('user')
        ->add('categorieArticle')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
