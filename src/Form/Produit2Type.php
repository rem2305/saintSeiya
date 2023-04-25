<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class Produit2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('content')
            // on ajoute le champ "images" dans le formulaire
            // il n'est pas lié à la BDD (mapped à false)
            ->add('images', FileType::class, [
                'label' => false,
                'multiple' => true,
               'mapped' => false,
               'required' => false
            ])
            ->add('Prix')
            ->add('Vendeur1')
            ->add('Vendeur2')
            ->add('Introduction')
            ->add('TitreSecondaire')
            ->add('TitreConclusion')
            ->add('Conclusion')
            ->add('dateDeCreation')
            ->add('categorieProduit')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
