<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [            
                'attr' => ['placeholder' => 'Tapez le titre principal'], 'label' => false
            ])
            ->add('imageForm',  FileType::class, ['label' => false,
                'mapped' => false, 'required' => false
            ])
            ->add('Introduction', TextareaType::class, [            
            'attr' => ['placeholder' => 'Tapez l\'introduction'], 'label' => false
        ])
            ->add('TitreSecondaire', TextType::class, [            
                'attr' => ['placeholder' => 'Tapez le titre secondaire'], 'label' => false
            ])
            ->add('content', TextareaType::class, [            
                'attr' => ['placeholder' => 'Tapez le paragraphe'], 'label' => false
            ])
            ->add('TitreConclusion', TextType::class, [            
                'attr' => ['placeholder' => 'Tapez le titre de la conclusion'], 'label' => false
            ])
            ->add('Conclusion', TextareaType::class, [            
                'attr' => ['placeholder' => 'Tapez la conclusion'], 'label' => false
            ])
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
