<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [            
                'attr' => ['placeholder' => 'Votre email'], 'label' => false
            ])
            ->add('sujet', TextType::class, [            
                'attr' => ['placeholder' => 'Le sujet de votre message'], 'label' => false
            ])
            ->add('message', TextareaType::class, [            
                'attr' => ['placeholder' => 'Votre message'], 'label' => false
            ])
            ->add('confirmer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
