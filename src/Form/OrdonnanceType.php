<?php

namespace App\Form;

use App\Entity\Ordonnance;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdonnanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomMedecin', TextType::class, [
                'label' => 'Nom medecin',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom medecin',
                ]
            ])
            ->add('nomPatient', TextType::class, [
                'label' => 'Nom patient',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom patient'
                ]
            ])
            ->add('commentaire', TextareaType::class, [
                'label' => 'Commentaire',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Commentaire'
                ],
            ])->add('ordonnanceMedicaments', CollectionType::class, [
                // each entry in the array will be an "email" field
                'entry_type' => OrdonnanceMedicamentType::class,
                // these options are passed to each "email" type
                'allow_add' => true,
                'mapped' => false,
                'allow_delete' => true
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ordonnance::class,
        ]);
    }
}
