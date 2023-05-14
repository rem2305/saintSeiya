<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [            
                'attr' => ['placeholder' => 'Tapez le titre principal'], 'label' => false])
            ->add('images', FileType::class, [
              'label' => false,
              'multiple' => true,
              'mapped' => false,
              'required' => false
            ])
            ->add('prix', NumberType::class, [            
                'attr' => ['placeholder' => 'Tapez le prix 1'], 'label' => false])
            ->add('vendeur1', TextType::class, [            
                'attr' => ['placeholder' => 'Tapez le nom du vendeur 1'], 'label' => false])
            ->add('lien', UrlType::class, [
              'default_protocol' => 'https',
              'required' => false,
              'attr' => [
                  'class' => 'form-control',
                  'placeholder' => 'collez le lien 1 ici',
                  'pattern' => '^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$'
              ], 'label' => false
          ])
            ->add('prix2', NumberType::class, [            
                'attr' => ['placeholder' => 'Tapez le prix 2'], 'label' => false])
            ->add('vendeur2', TextType::class, [            
                'attr' => ['placeholder' => 'Tapez le nom du vendeur 2'], 'label' => false])
            ->add('lien2', UrlType::class, [
              'default_protocol' => 'https',
              'required' => false,
              'attr' => [
                  'class' => 'form-control',
                  'placeholder' => 'collez le lien 2 ici',
                  'pattern' => '^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$'
              ], 'label' => false
          ])
            ->add('introduction', TextareaType::class, [            
                'attr' => ['placeholder' => 'Tapez l\'introduction'], 'label' => false
            ])
            ->add('titreSecondaire', TextType::class, [            
                'attr' => ['placeholder' => 'Tapez le titre secondaire'], 'label' => false])
            ->add('content', TextareaType::class, [            
                'attr' => ['placeholder' => 'Tapez le paragraphe'], 'label' => false
            ])
            ->add('titreConclusion', TextType::class, [            
                'attr' => ['placeholder' => 'Tapez le titre de la conclusion'], 'label' => false])
            ->add('conclusion', TextareaType::class, [            
                'attr' => ['placeholder' => 'Tapez la conclusion'], 'label' => false
            ])
            /* ->add('user') */
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
