<?php

namespace App\Form;

use App\Entity\Fiche;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FicheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tel')
            ->add('genre', ChoiceType::class, [
                'choices' => [
                    'Femme' => 'Femme',
                    'Homme' => 'Homme',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('date_naissance', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('etatClinique', ChoiceType::class, [
                'choices' => [
                    'Bon' => 'Bon',
                    'Moyen' => 'Moyen',
                    'Mauvais' => 'Mauvais',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('typeAssurance',ChoiceType::class, [
                'choices' => [
                    'Commune' => 'Commune',
                    'Semi Privée' => 'Semi Privée',
                    'Privée' => 'Privée',
                ],
                'expanded' => true,
                'multiple' => false,
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fiche::class,
        ]);
    }
}
