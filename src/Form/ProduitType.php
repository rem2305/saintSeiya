<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            /* ->add('imageForm',  FileType::class,  
            [
                'label' => 'Ajoutez vos images',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'constraints' => [
                    new All([
                      'constraints' => [
                        new File([
                          'maxSize' => '3000k',
                          'mimeTypesMessage' => 'Merci d\'ajouter un fichier image valide',
                          'mimeTypes' => [
                            'image/*'
                          ]
                        ]),
                      ],
                    ]),
                  ]
                ]) */
            ->add('images', FileType::class, [
              'label' => false,
              'multiple' => true,
              'mapped' => false,
              'required' => false
            ])
            ->add('prix')
            ->add('vendeur1')
            ->add('vendeur2')
            ->add('introduction')
            ->add('titreSecondaire')
            ->add('content')
            ->add('titreConclusion')
            ->add('conclusion')
            ->add('user')
            ->add('categorieProduit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
