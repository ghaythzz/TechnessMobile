<?php

namespace App\Form;

use App\Entity\Medicament;
use App\Entity\OrdonnanceMedicament;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrdonnanceMedicamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dosage', NumberType::class, [
                'label' => 'Dosage',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Dosage'
                ]
            ])
            ->add('duration', NumberType::class, [
                'label' => 'Duration',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Duration'
                ]
            ])
            ->add('medicament', EntityType::class, [
                'label' => 'Medicament',
                'class' => Medicament::class,
                'placeholder' => 'Choose a med',
                'choice_label' => 'nom',
                'attr' => [
                    'class' => 'form-select',
                    'style' => 'height: 100%;'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
